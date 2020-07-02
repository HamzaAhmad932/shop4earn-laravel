<?php

namespace App\Http\Controllers\Admin;

use App\Earning;
use App\User;
use App\Product;
use App\Customer;
use Carbon\Carbon;
use App\SaleDetail;
use App\CustomSetting;
use App\DefaultSponsor;
use App\Http\Traits\CustomerTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SalesBonusCalculateJob;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    use CustomerTrait;

    public function saveCustomer(CustomerRequest $request){

        try {

            $customer = $this->createCustomer($request);

            if (! empty($customer)){
                $lease_sale = $this->createSaleDetail($request, $customer);
                $this->giveTeamBonus($customer);
                $this->giveSalebonus($customer->parent_id);
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
        $sponsor_present = !empty($request->sponsor_id);
        if($sponsor_present){
            if(!$request->is_manual){
                $parent_id = $this->getTreeNodeFromManualPosition($request->sponsor_id, $request->position);
            }else{
                if($request->parent_id != '') {
                    $parent_id = $request->parent_id;
                }else{
                    $parent_id = $this->getTreeNodeFromManualPosition($request->sponsor_id, $request->position);
                }
            }
        }else{
            if(!$request->is_manual) {
                $parent_id = CustomSetting::find(1)->default_sponsor_id;
            }else{
                if($request->parent_id != '') {
                    $parent_id = $request->parent_id;
                }else{
                    $parent_id = CustomSetting::find(1)->default_sponsor_id;
                }
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' =>  $request->email,
            'password' => Hash::make($request->password),
            'role_id'=> User::CUSTOMER_ROLE,
            'city'=> $request->city,
            'mobile'=> $request->mobile,
        ]);

        $customer =  Customer::create([
            'user_id' => $user->id,
            'parent_id' => $parent_id,
            'sponsor_id' => $request->sponsor_id,
            'rank_id' => 1, //zero level by default
            'position' => $request->position,
            'is_paired' => 0,
            'status'=> Customer::STATUS_ACTIVE
        ]);

        if ($customer) {
            $user->update(['customer_id'=> $customer->id]);
            if($sponsor_present){
                $this->updateSponsorRank($request->sponsor_id);
            }
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

        return SaleDetail::insert($bulk_sale);
    }

    public function getAvailableSponsorsAndProducts(Request $request)
    {
        $parent_id = $request->parent_id;
        if(!empty($parent_id)){

            $upline_customer_ids = $this->getUplineIDs($parent_id);

            $customers = User::with('sponsor')
                ->whereNotIn('role_id', [
                    User::SUB_ADMIN_ROLE,
                    User::SUPER_ADMIN_ROLE
                ])->whereIn('id', $upline_customer_ids)->get();
        }else{
            $customers = User::with('sponsor')
                ->whereNotIn('role_id', [
                    User::SUB_ADMIN_ROLE,
                    User::SUPER_ADMIN_ROLE
                ])->get();
        }
        $products = Product::all();
        $get_mx_id = User::max('id');

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

    public function testTeamBonus(){

        $this->giveTeamBonus(Customer::find(1103));

    }

    public function rankupdate(){

        $parent_id = 1105;
        $upline = $this->getUplineIDs($parent_id);
        SalesBonusCalculateJob::dispatchNow($parent_id);

    }
}

