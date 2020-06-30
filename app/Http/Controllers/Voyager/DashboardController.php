<?php

namespace App\Http\Controllers\Voyager;

use App\User;
use App\Rank;
use App\Customer;
use Carbon\Carbon;
use App\CustomSetting;
use TCG\Voyager\Facades\Voyager;
use App\Http\Traits\CustomerTrait;
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
            'cf'=> $cf,
            'cf_pos'=> empty($cf_position) ? '' : '('.$cf_position.')',
            'sb'=> $sb,
            'tb'=> $tb,
            'rank'=> $rank,
            'upcoming_rank'=> $upcoming_rank,
            'balance'=> $balance,
            'total_earned'=> $total_earned,
            'user'=> $user,
            'withdrawn'=> $withdrawn,
            'label'=> ['Left-'.count($left_childs), 'Right-'.count($right_childs)],
            'series'=> [count($left_childs), count($right_childs)]
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
        $this->giveSalebonus($customer->parent_id);

        return redirect()->back();
    }
}
