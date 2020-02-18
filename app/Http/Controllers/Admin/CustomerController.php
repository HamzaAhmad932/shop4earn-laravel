<?php

namespace App\Http\Controllers\Admin;

use App\Earning;
use App\User;
use App\Product;
use App\Customer;
use Carbon\Carbon;
use App\SaleDetail;
use App\DefaultSponsor;
use App\Http\Traits\CustomerTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    use CustomerTrait;

    public function saveCustomer(CustomerRequest $request){

        try {

            $customer = $this->createCustomer($request);

            if (! empty($customer)){
                $lease_sale = $this->createSaleDetail($request, $customer);
            }
            else{
                return self::apiErrorResponse('Fail to save Customer', 500);
            }

            return self::apiSuccessResponse(
                'Customer added successfully',
                200,
                ['customer' => $customer, 'lease_sale' => $lease_sale]
            );

        } catch (\Exception $exception) {
            Log::error($exception->getMessage(), ['StackTrace' => $exception->getTraceAsString()]);
            return self::apiErrorResponse($exception->getMessage().' Fail to save Customer', 500);
        }

    }

    public function createCustomer(CustomerRequest $request)
    {
        if(!empty($request->sponsor_id)){
            $parent_id = $this->getTreeNodeFromManualPosition($request->sponsor_id, $request->position);

            $this->updateSponsorRank($request->sponsor_id);
        }else{
            $parent_id = DefaultSponsor::find(1)->user_id;
        }

        $customer =  Customer::create([
            'user_id' => $request->user_id,
            'parent_id' => $parent_id,
            'sponsor_id' => $request->sponsor_id,
            'rank_id' => 1, //zero level by default
            'position' => $request->position,
            'is_paired' => 0,
            'status'=> Customer::STATUS_ACTIVE
        ]);

        if ($customer) {
            User::create([
                'name' => $request->user_name,
                'email' =>  $request->email,
                'password' => Hash::make($request->password),
                'customer_id' => $customer->id,
                'role_id'=> User::CUSTOMER_ROLE
            ]);
        }
        return $customer;
    }

    public function createSaleDetail($request, Customer $customer)
    {
        $bulk_sale = [];
        $product_ids = array_column($request->selected_products, 'product_id');
        $products = Product::whereIn('id', $product_ids)->get();
        foreach ($request->selected_products as $p){

            $product = $products->where('id', $p['product_id'])->first();
            $sale = [
                'user_id' => $customer->user_id,
                'product_id' => $product->id,
                'product_code' => $product->product_code,
                'product_price' => abs($product->product_price),
                'pv' => $product->pv,
                'bv' => $product->bv,
                'tb' => $product->tb,
                'color_id' => 0,
                'size_id' => 0,
                'quantity' => $p['qty'],
                'discount' => $product->discount,
                'IP' => Request()->ip(),
                'created_at'=> now()->toDateTimeString(),
                'updated_at'=> now()->toDateTimeString(),
            ];
            array_push($bulk_sale, $sale);
        }

        $sale_detail =  SaleDetail::insert($bulk_sale);
    }

    public function getAvailableSponsorsAndProducts()
    {
        $customers = User::with('sponsor')
            ->whereNotIn('role_id', [
                User::SUB_ADMIN_ROLE,
                User::SUPER_ADMIN_ROLE
            ])->get();
        $products = Product::all();
        $get_mx_id = !empty($customers->last()) ? $customers->last()->id : 0;

        $product = $products->transform(function ($product) {
            return [
                'code' => $product->id,
                'label' => $product->id.'- '.$product->product_name,
            ];
        });

        $sponsors = $customers->transform(function ($customer) {

            $left_count = !empty($customer->sponsor) ? $customer->sponsor->where('position', Customer::POSITION_LEFT)->count() : 0;
            $right_count = !empty($customer->sponsor) ? $customer->sponsor->where('position', Customer::POSITION_RIGHT)->count() : 0;
            $all_count = !empty($customer->sponsor) ? $customer->sponsor->count() : 0;

            return [
                'code' => $customer->id,
                'label' => $customer->id.'- '.$customer->name. '|L='.$left_count.'|R='.$right_count.'|All='.$all_count,
            ];
        });

        return self::apiSuccessResponse('success', 200, [
            'sponsors'=> $sponsors,
            'products'=> $product,
            'mx_id'=> $get_mx_id+1
        ]);
    }


    public function bvCal() {


        $users = User::select('id')->with(['customer', 'earnings'])->get();

        /**
         * @var User $user
         */


        dd(self::$user_id);
        foreach ($users as $user) {

            self::$user_id = [3];//[$user->id];

            $right_last_earning = $user->earnings->where('position', Customer::POSITION_RIGHT)->last();
            $left_last_earning = $user->earnings->where('position', Customer::POSITION_LEFT)->last();

            $left_childs_bv = $left_last_earning->carry_forward ?? 0;
            $right_childs_bv = $right_last_earning->carry_forward ?? 0;

            $start_date = !empty($right_last_earning)
                ? Carbon::parse($right_last_earning->created_at)->addDay(1)->startOfDay()->toDateTimeString()
                : now()->startOfDay()->toDateTimeString();

            $end_date = Carbon::parse($start_date)->endOfDay()->toDateTimeString();

            $left_childs = implode(',', $this->getAllChilds(Customer::POSITION_LEFT));
            $right_childs = implode(',', $this->getAllChilds(Customer::POSITION_RIGHT));

            if (!empty($left_childs)) {
                $sale = DB::select(DB::raw("select sum(quantity*bv) as total_bv from sale_details where user_id IN($left_childs) and created_at >= '{$start_date}' and created_at <= '{$end_date}'"));
                $left_childs_bv += $sale[0]->total_bv ?? 0;
            }

            if (!empty($right_childs)) {
                $sale = DB::select(DB::raw("select sum(quantity*bv) as total_bv from sale_details where user_id IN ($right_childs) and created_at >= '{$start_date}' and created_at <= '{$end_date}'"));
                $right_childs_bv += $sale[0]->total_bv ?? 0;
            }

            if ($left_childs_bv < $right_childs_bv) { // Left Weaker

                $points = ($left_childs_bv / 100) * $user->customer->rank->required_basic;

                $earnings = array(
                    [
                        'user_id' => $user->id, 'direct_bonus' => 0, 'team_bonus' => 0, 'sales_bonus' => $points,
                        'carry_forward' => 0, 'position' => Customer::POSITION_LEFT, 'paid' => 0
                    ],
                    [
                        'user_id' => $user->id, 'direct_bonus' => 0, 'team_bonus' => 0, 'sales_bonus' => 0,
                        'carry_forward' => abs($left_childs_bv - $right_childs_bv), 'position' => Customer::POSITION_RIGHT, 'paid' => 0
                    ]
                );

            } else { //Right Weaker

                $points = ($right_childs_bv / 100) * $user->customer->rank->required_basic;

                $earnings = array(
                    [
                        'user_id' => $user->id, 'direct_bonus' => 0, 'team_bonus' => 0, 'sales_bonus' => $points,
                        'carry_forward' => 0, 'position' => Customer::POSITION_RIGHT, 'paid' => 0
                    ],
                    [
                        'user_id' => $user->id, 'direct_bonus' => 0, 'team_bonus' => 0, 'sales_bonus' => 0,
                        'carry_forward' => abs($left_childs_bv - $right_childs_bv), 'position' => Customer::POSITION_LEFT, 'paid' => 0
                    ]
                );

            }

            Earning::insert($earnings);
        }
    }


    public static $childs = [];
    public static $user_id = [1];
    public static $customers = [];

    public function getAllChilds($position, $iteration = 0) {

        if (empty(self::$customers))
            self::$customers = Customer::all();

        $leaves = self::$customers->whereIn('parent_id', self::$user_id);


        if ($iteration == 0) {
            $neglect_child = self::$customers->whereIn('parent_id', self::$user_id)->where('position', '!=', $position)->first();

            if (! empty($neglect_child))
                $leaves = $leaves->where('user_id', '!=', $neglect_child->user_id);

            $iteration++;
        }

        $leaves = $leaves->pluck('user_id')->toArray();

        if (!empty($leaves)) {
            self::$user_id = $leaves;
            self::$childs = array_merge(self::$childs, $leaves);
            $this->getAllChilds($iteration, $position);
        }

        return self::$childs;
    }
}
