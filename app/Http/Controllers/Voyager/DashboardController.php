<?php

namespace App\Http\Controllers\Voyager;

use App\User;
use App\Rank;
use TCG\Voyager\Facades\Voyager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CustomerDashboardResource;

class DashboardController extends Controller
{
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
        if(!empty($earning)){
            $balance = (floatval($earning->team_bonus) + floatval($earning->sales_bonus)) - floatval($earning->paid);
            $total_earned = (floatval($earning->team_bonus) + floatval($earning->sales_bonus));
        }

        return response()->json([
            'referral'=> $referrals,
            'cf'=> $cf,
            'sb'=> $sb,
            'tb'=> $tb,
            'rank'=> $rank,
            'upcoming_rank'=> $upcoming_rank,
            'balance'=> $balance,
            'total_earned'=> $total_earned
        ]);

    }
}
