<?php

namespace App\Http\Controllers\Voyager;

use App\User;
use App\Rank;
use App\Customer;
use Carbon\Carbon;
use App\SaleDetail;
use App\CustomSetting;
use App\PayoutRequest;
use TCG\Voyager\Facades\Voyager;
use App\Http\Traits\CustomerTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CustomerDashboardResource;

class DashboardController extends Controller
{
    use CustomerTrait;
    public static $childs = [];
    public static $user_id = [1];
    public static $customers = [];

    public function index(){

//        return Voyager::view('voyager::index');

        //$view = 'vendor.voyager.dashboard.admin';
        //return view($view);
        $user_role = Auth::user()->role_id;

        if($user_role != User::CUSTOMER_ROLE){

            $view = 'vendor.voyager.dashboard.admin';
            return view($view);
            //return Voyager::view('voyager::index');
        }else{
            $view = 'vendor.voyager.dashboard.customer';
            return view($view);
        }
    }

    public function dashboardData(Request $request){

        $customer = Auth::user();
        if($customer->role_id == User::CUSTOMER_ROLE){
            return $this->customerDashboardData($customer);
        } else {
            return $this->adminDashboardData($customer);
        }
    }

    public function adminDashboardData($user){

        $members = Customer::all();
        $current_date = Carbon::now('Asia/Karachi')->toDateString();
        $previous_month = Carbon::now()->subDays(15);

        $approved_members = $members->where('status', Customer::STATUS_ACTIVE);
        $total_paid_amount = PayoutRequest::where('status', PayoutRequest::PAID_STATUS)->sum('payable_amount');
        $today_joined = Customer::where('created_at', $current_date)->count();
        $total_amount = DB::select('select sum((sd.product_price * sd.quantity - sd.discount)) as actual_sale_price, sum(((sd.product_price * sd.quantity) - (p.purchase_cost * sd.quantity)) - sd.discount) as profit_amount from sale_details sd JOIN products p on(sd.product_id = p.id);')[0];
        $admin_amount = DB::select('select sum(admin_charges) as admin_charges, sum(donation) as donations from payout_requests where status = 1;')[0];
        $rank_overview = DB::select("
                                        select
                                            c.rank_id,
                                            r.rank_name,
                                            COUNT(*) as members,
                                            CASE
                                                WHEN c.rank_id = 1 THEN 'gd-success'
                                                WHEN c.rank_id = 2 THEN 'gd-success'
                                                WHEN c.rank_id = 3 THEN 'gd-info'
                                                WHEN c.rank_id = 4 THEN 'gd-primary'
                                                WHEN c.rank_id = 5 THEN 'gd-warning'
                                                WHEN c.rank_id = 6 THEN 'gd-warning'
                                             END
                                             as class_name
                                        from
                                        customers c join ranks r on(c.rank_id = r.id) GROUP BY c.rank_id;
        ");
        $withdraw_requests = DB::select('SELECT pr.user_id, u.name, pr.payable_amount, pr.created_at FROM payout_requests pr JOIN users u on (pr.user_id = u.id) where pr.status = 0 order by pr.created_at desc limit 10;');
        $users = collect(DB::select('select e.user_id, CAST(e.earned as DECIMAL) as earned, u.avatar, u.name from earnings e join users u on(e.user_id = u.id) order by 2 desc limit 5;'));
        $line = collect(DB::select("select CEIL(sum(product_price)) as sale_amount, date(created_at) as created_at, DATE_FORMAT(date(created_at), '%e %b') as created_At from sale_details where created_at between '".date($previous_month->toDateString())."' and '".date(Carbon::today()->addDay(1)->toDateString())."' GROUP by 2, 3 order by 2, 3 desc;"));

        $users->transform(function ($user){
            return [
                'user_id'=> $user->user_id,
                'earned'=> 'Rs.'.number_format($user->earned, 0),
                'avatar'=> Voyager::image($user->avatar),
                'name'=> $user->name
            ];
        });

        return response()->json([
            'user'=> $user,
            'total_network_members'=> $members->count(),
            'total_approved_customers'=> $approved_members->count(),
            'total_paid_amount'=> number_format($total_paid_amount, 0),
            'today_joined'=> $today_joined,
            'total_sale'=> number_format($total_amount->actual_sale_price, 0),
            'profit'=> number_format($total_amount->profit_amount, 0),
            'admin_amount'=> number_format($admin_amount->admin_charges, 0),
            'donations'=> number_format($admin_amount->donations, 0),
            'top_users'=> $users,
            'rank_overview'=> $rank_overview,
            'withdrawal_requests'=> $withdraw_requests,
            'line_graph'=>[
                'label'=> $line->pluck('created_At'),
                'series'=> $line->pluck('sale_amount')
            ]
        ]);
    }

    public function customerDashboardData($user){

        $earning = $user->earning;
        $customer = $user->customer;
        $referrals = $user->customer->sponsors->count();
        $cf = !empty($earning) ? $earning->carry_forward : 0;
        $sb = !empty($earning) ? $earning->sales_bonus : 0;
        $tb = !empty($earning) ? $earning->team_bonus : 0;
        $rank = !empty($customer) ? $customer->rank->rank_name : 'Member';
        $u_rank = Rank::where('id', $customer->rank->id + 1)->first();
        $upcoming_rank = !empty($u_rank) ? $u_rank->rank_name : false;
        $balance = 0;
        $total_earned = 0;
        $withdrawn = 0;
        if(!empty($earning)){
            $balance = (floatval($earning->team_bonus) + floatval($earning->sales_bonus)) - floatval($earning->paid);
            $total_earned = (floatval($earning->team_bonus) + floatval($earning->sales_bonus));
            $withdrawn = $earning->paid;
        }

        self::$user_id = [$user->id];
        self::$childs = [];
        $left_childs = $this->getAllChilds(Customer::POSITION_LEFT);
        self::$childs = [];
        self::$user_id = [$user->id];
        $right_childs = $this->getAllChilds(Customer::POSITION_RIGHT);

        if(!empty($user->salesBonusDetail)){
            $last_sale_entry = $user->salesBonusDetail->sortByDesc('created_at')->take(2)->where('carry_forward', '!=', 0)->first();
            $cf_position = !empty($last_sale_entry) ? $last_sale_entry->position == 1 ? 'Left': 'Right' : '';
        }

        return response()->json([
            'referral'=> $referrals,
            'cf'=> number_format($cf, 0),
            'cf_pos'=> empty($cf_position) ? '' : '('.$cf_position.')',
            'sb'=> number_format($sb, 0),
            'tb'=> number_format($tb, 0),
            'rank'=> $rank,
            'upcoming_rank'=> $upcoming_rank,
            'balance'=> number_format($balance, 0),
            'total_earned'=> number_format($total_earned, 0),
            'user'=> $user,
            'withdrawn'=> number_format($withdrawn, 0),
            'label'=> ['Left-'.count($left_childs), 'Right-'.count($right_childs)],
            'series'=> [count($left_childs), count($right_childs)],
            'is_customer'=> true
        ]);

    }

    public function getAllChilds($position, $iteration = 0) {

        if (empty(self::$customers)) {
            self::$customers = Customer::all();
        }

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
            $this->getAllChilds($position, $iteration);
        }

        return self::$childs;
    }

    public function activateCustomer(Request $request)
    {

        $customer = Customer::find($request->customer_id);
        $sponsor_id = $customer->temp_sponsor_id;

        $sponsor_present = !empty($customer->temp_sponsor_id);

        if($sponsor_present)
        {
            $parent_id = $this->getTreeNodeFromManualPosition($customer->temp_sponsor_id, $customer->position);
        }else{

            $sponsor_id = CustomSetting::find(1)->default_sponsor_id;
            $parent_id = $this->getTreeNodeFromManualPosition($sponsor_id, $customer->position);
        }

        $customer->update([
            'parent_id'=> $parent_id,
            'sponsor_id'=>$sponsor_id,
            'is_paired'=> 0,
            'status'=> Customer::STATUS_ACTIVE
        ]);

        $this->updateSponsorRank($sponsor_id);
        $this->giveTeamBonus($customer);

        return redirect()->back();
    }
}
