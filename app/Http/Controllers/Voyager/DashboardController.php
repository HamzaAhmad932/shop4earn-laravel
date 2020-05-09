<?php

namespace App\Http\Controllers\Voyager;

use App\User;
use App\Rank;
use App\Customer;
use Carbon\Carbon;
use TCG\Voyager\Facades\Voyager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CustomerDashboardResource;

class DashboardController extends Controller
{
    public static $childs = [];
    public static $user_id = [1];
    public static $customers = [];

    public function index(){

//        return Voyager::view('voyager::index');

        //$view = 'vendor.voyager.dashboard.admin';
        //return view($view);
        $user_role = Auth::user()->role_id;

        if($user_role != User::CUSTOMER_ROLE){
            return Voyager::view('voyager::index');
        }else{
            $view = 'vendor.voyager.dashboard.customer';
            return view($view);
        }
    }

    public function dashboardData(Request $request){

        $customer = Auth::user();
        if($customer->role_id == User::CUSTOMER_ROLE){
            return $this->customerDashboardData($customer);
        }
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
            $total_earned = (floatval($earning->team_bonus) + floatval($earning->sales_bonus)).' (Sales Bonus + Team Bonus)';
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
            $cf_position = !empty($last_sale_entry) ? $last_sale_entry->position == 1 ? 'L': 'R' : '';
            $cf .= ' ('.$cf_position.')';
        }

        return response()->json([
            'referral'=> $referrals,
            'cf'=> $cf,
            'sb'=> $sb,
            'tb'=> $tb,
            'rank'=> $rank,
            'upcoming_rank'=> $upcoming_rank,
            'balance'=> $balance,
            'total_earned'=> $total_earned,
            'user'=> $user,
            'withdrawn'=> $withdrawn,
            'label'=> ['Left', 'Right'],
            'series'=> [count($left_childs), count($right_childs)]
        ]);

    }

    public function findMembersCount(User $user, $position){

//        $child = $user->child_sponsor->where('position', $position)->first();
//        if(empty($child)){
//            return $this->downline_count;
//        }
//        $this->downline_count = 1;
//        return $this->getDownlineCount($child);

        dd($left_childs);

    }

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
            $this->getAllChilds($position, $iteration);
        } else {
            self::$childs = self::$customers->where('is_paired', Customer::NOT_PAIRED)->whereIn('user_id', self::$childs)->pluck('user_id')->toArray();
        }

        return self::$childs;
    }
}