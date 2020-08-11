<?php


namespace App\Http\Traits;


use App\Rank;
use App\User;
use App\Reward;
use App\Earning;
use App\Customer;
use App\SaleDetail;
use App\RewardType;
use App\UserReward;
use App\Compensation;
use App\SalesBonusDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Jobs\SalesBonusCalculateJob;
use Illuminate\Support\Facades\Artisan;

trait CustomerTrait
{
    protected static $childs = [];
    protected static $user_id = [1];
    protected static $customers = [];
    public $upline = [];

    public function getTreeNodeFromManualPosition(int $sponsor_id, int $position){

        return $position == '1' ? $this->findLeftPosition($sponsor_id) : $this->findRightPosition($sponsor_id);
    }


    public function findLeftPosition(int $sponsor_id){

        $sponsor = Customer::where([
            ['parent_id', '=', $sponsor_id],
            ['position', '=', Customer::POSITION_LEFT]
        ])->first();


        if(empty($sponsor)){
            return $sponsor_id;
        }

        return $this->findLeftPosition($sponsor->user_id);
    }

    public function findRightPosition(int $sponsor_id){

        $sponsor = Customer::where([
            ['parent_id', '=', $sponsor_id],
            ['position', '=', Customer::POSITION_RIGHT]
        ])->first();

        if(empty($sponsor)){
            return $sponsor_id;
        }

        return $this->findRightPosition($sponsor->user_id);
    }
    public function findBasicCountInLeg(int $user_id, int $basic_rank_count = 0, $total_child=0){

        $children = Customer::where([
            ['parent_id', '=', $user_id],
            ['status', '=', Customer::STATUS_ACTIVE],
        ])->get();

        foreach ($children as $child){
            $total_child++;
            if ($child->rank_id == Rank::BASIC){
                $basic_rank_count++;
            }
            return $this->findBasicCountInLeg($child->user_id, $basic_rank_count, $total_child);
        }

        return ['basic_count'=>$basic_rank_count, 'total_child'=> $total_child];
    }

    public function updateSponsorRank(int $sponsor_id){

        $direct_sponsor_count = Customer::where([
            ['sponsor_id', '=', $sponsor_id],
            ['status', '=', Customer::STATUS_ACTIVE]
        ])->count();

        $direct_sponsor_count_left = Customer::where([
            ['sponsor_id', '=', $sponsor_id],
            ['position', '=', Customer::POSITION_LEFT],
            ['status', '=', Customer::STATUS_ACTIVE]
        ])->count();

        $direct_sponsor_count_right = Customer::where([
            ['sponsor_id', '=', $sponsor_id],
            ['position', '=', Customer::POSITION_RIGHT],
            ['status', '=', Customer::STATUS_ACTIVE]
        ])->count();

        $left = Customer::where([
            ['parent_id', '=', $sponsor_id],
            ['position', '=', Customer::POSITION_LEFT],
            //['rank_id', '=', Rank::BASIC],
            ['status', '=', Customer::STATUS_ACTIVE],
        ])->first();

        $right = Customer::where([
            ['parent_id', '=', $sponsor_id],
            ['position', '=', Customer::POSITION_RIGHT],
            //['rank_id', '=', Rank::BASIC],
            ['status', '=', Customer::STATUS_ACTIVE]
        ])->first();

        $l_rank_counter = 0;
        $r_rank_counter = 0;

        if(!empty($left->user_id) && $left->rank_id == Rank::BASIC){
            $l_rank_counter = 1;
        }

        if(!empty($right->user_id) && $right->rank_id == Rank::BASIC){
            $r_rank_counter = 1;
        }

        $left_data = !empty($left->user_id) ? $this->findBasicCountInLeg($left->user_id, $l_rank_counter) : ['basic_count'=> 0, 'total_child'=> 0];
        $right_data = !empty($right->user_id) ? $this->findBasicCountInLeg($right->user_id, $r_rank_counter) : ['basic_count'=> 0, 'total_child'=> 0];

        $left_basic_count = $left_data['basic_count'];
        $right_basic_count = $right_data['basic_count'];

        $basic_level_members_in_weaker_leg = 0;

        if($left_data['total_child'] < $right_data['total_child']){

            $basic_level_members_in_weaker_leg = $left_basic_count;
        }

        if($right_data['total_child'] < $left_data['total_child']){

            $basic_level_members_in_weaker_leg = $right_basic_count;
        }

        if($right_basic_count == $left_basic_count){

            if($left_basic_count > 0){

                $basic_level_members_in_weaker_leg = $left_basic_count;
            }
        }

        $ranks = Rank::all();
        $basic_rank = $ranks->where('id', Rank::BASIC)->first();
        $standard_rank = $ranks->where('id', Rank::STANDARD)->first();
        $silver_rank = $ranks->where('id', Rank::SILVER)->first();
        $gold_rank = $ranks->where('id', Rank::GOLD)->first();
        $diamond = $ranks->where('id', Rank::DIAMOND)->first();
        $user_rank = Rank::ZERO;

//        dd(['direct'=>$direct_sponsor_count, 'left'=>$left, 'right'=>$right, 'basic_in_weaker'=>$basic_level_members_in_weaker_leg]);

        $customer = Customer::where('user_id', $sponsor_id)->first();

        if(($direct_sponsor_count_right + $direct_sponsor_count_left) >= $basic_rank->direct_referral && $basic_level_members_in_weaker_leg >= $basic_rank->required_basic){
            $user_rank = Rank::BASIC;
        }
        if(intval($customer->rank_id) >= Rank::BASIC) {
            if ($direct_sponsor_count >= $standard_rank->direct_referral && $basic_level_members_in_weaker_leg >= $standard_rank->required_basic) {
                $user_rank = Rank::STANDARD;
            }

            if ($direct_sponsor_count >= $silver_rank->direct_referral && $basic_level_members_in_weaker_leg >= $silver_rank->required_basic) {
                $user_rank = Rank::SILVER;
            }

            if ($direct_sponsor_count >= $gold_rank->direct_referral && $basic_level_members_in_weaker_leg >= $gold_rank->required_basic) {
                $user_rank = Rank::GOLD;
            }

            if ($direct_sponsor_count >= $diamond->direct_referral && $basic_level_members_in_weaker_leg >= $diamond->required_basic) {
                $user_rank = Rank::DIAMOND;
            }
        }

        //update(['rank_id' => $user_rank]);
        if($user_rank > intval($customer->rank_id)){
            $customer->rank_id = $user_rank;
            $customer->save();
        }
    }

    public function giveTeamBonusReward(Customer $customer){

        $user = $customer->user;
        $earning = $customer->earning;
        $rewards_given = $user->user_rewards;
        $rewards = Reward::whereNotIn('id', $rewards_given->pluck('id'))->where('reward_type_id', RewardType::TEAM_BONUS_REWARD_TYPE)->get();

        if(!empty($earning->team_bonus)) {
            foreach ($rewards as $reward) {

                /*
                |--------------------------------------------------------------------------
                | Reward Tier Amount Condition
                |--------------------------------------------------------------------------
                |
                |   The condition below check that a particular user achieve enough team bonus
                |   amount that it is now able to get reward according to the tier amount
                |   that is achieved.
                |
                */

                if ((float)$earning->team_bonus >= (float)$reward->tier_amount) {
                    // Updating Earning entries after reward given
                    $earning->update([
                        'team_bonus' => (float)$earning->team_bonus + (float)$reward->reward_amount,
                        'earned' => (float)$earning->sales_bonus + (float)$earning->team_bonus,
                    ]);

                    // User Reward Pivot table entry
                    UserReward::create([
                        'user_id' => $user->id,
                        'reward_id' => $reward->id,
                    ]);
                }

            }
        }
    }

    public function giveTeamBonus(Customer $customer)
    {
        $compensation = Compensation::all();

        $sale_detail = $customer->salesDetail;
        $team_bonus_points = 0;
        foreach ($sale_detail as $sale){
            $team_bonus_points += floatval($sale->tb) * intval($sale->quantity);
        }
        $this->teamBonusDeliver($customer, $team_bonus_points, $compensation);
        $this->giveTeamBonusReward($customer);
    }

    public function teamBonusDeliver($user, $total_points, $commission_compensation, $level = 1){

        try {

            $sponsor = Customer::where('user_id', $user->sponsor_id)->first();

            if(empty($sponsor) || $level > $commission_compensation->count()){
                return;
            }

            $compensation = $commission_compensation->where('level_number', $level)->first();
            $percentage = 0;
            switch ($sponsor->rank_id) {

                case 2:
                case 1:
                    $percentage = $compensation->basic;
                    break;
                case 3:
                    $percentage = $compensation->standard;
                    break;
                case 4:
                    $percentage = $compensation->silver;
                    break;
                case 5:
                    $percentage = $compensation->gold;
                    break;
                case 6:
                    $percentage = $compensation->diamond;
                    break;
            }

            $team_bonus = ($total_points / 100) * $percentage;
            $earnings = Earning::firstOrNew(['user_id' => $sponsor->user_id]);
            $earnings->team_bonus = (float) $earnings->team_bonus + $team_bonus;
            $earnings->earned = (float) $earnings->sales_bonus + (float) $earnings->team_bonus;
            $earnings->save();

            $level++;
            return $this->teamBonusDeliver($sponsor, $total_points, $commission_compensation, $level);
        }catch (\Exception $e){
            Log::error($e->getMessage(), [
                'File: '=>__FILE__,
                'Team Bonus Level: '=>$level,
                'User: '=>$sponsor,
                'Stack-Trace'=> $e->getTraceAsString()
            ]);
        }
    }

    public function deliverTeamBonus(array $sponsor_id, $commission_compensation, $sponsor, $level = 1){

        $children = Customer::whereIn('sponsor_id', $sponsor_id)->with('salesDetail')->get();
        if(!($children->count() > 0) || $level > $commission_compensation->count()){
            return;
        }
        $sponsor_ids = [];
        $tb_sum = 0;
        foreach ($children as $child){
            $tb_sum += $child->salesDetail->sum('tb');
            array_push($sponsor_ids, $child->user_id);
        }
        $compensation = $commission_compensation->where('level_number', $level)->first();
        $percentage = 0;
        switch ($sponsor->rank_id){

            case 2:
            case 1:
                $percentage = $compensation->basic;
                break;
            case 3:
                $percentage = $compensation->standard;
                break;
            case 4:
                $percentage = $compensation->silver;
                break;
            case 5:
                $percentage = $compensation->gold;
                break;
            case 6:
                $percentage = $compensation->diamond;
                break;
        }

        $team_bonus = ($tb_sum/100) * $percentage;

        $earnings = Earning::firstOrNew(['user_id' => $sponsor->user_id]);
        $earnings->team_bonus += $team_bonus;
        $earnings->save();

        $level++;
        return $this->deliverTeamBonus($sponsor_ids, $commission_compensation, $sponsor, $level);
    }

    public function giveSalebonus(Customer $customer){

        SalesBonusCalculateJob::dispatch($customer);
    }

    public function giveSalebonus_old(int $parent_id)
    {
        try {
            ini_set('max_execution_time', 0);
            $upline_user_ids = $this->getUplineIDs($parent_id);

            $users = User::select('id')
                ->where('role_id', 3)
                ->whereIn('id', $upline_user_ids)
                ->with(['customer', 'salesBonusDetail'])
                ->get();

            $now = now()->toDateTimeString();
            $update_is_paired_ids = [];

            foreach ($users as $user) {

                self::$user_id = NULL;
                self::$childs = NULL;
                self::$customers = NULL;

                //continue inactive customer
                $customer = $user->customer;
                if ($customer->status == 0) {
                    continue;
                }

                self::$user_id = [$user->id];
                self::$childs = [];

                $right_last_earning = $user->salesBonusDetail->where('position', Customer::POSITION_RIGHT)->last();
                $left_last_earning = $user->salesBonusDetail->where('position', Customer::POSITION_LEFT)->last();


                $left_childs = implode(',', $this->getAllChilds(Customer::POSITION_LEFT));

                self::$childs = [];
                self::$user_id = [$user->id];

                $right_childs = implode(',', $this->getAllChilds(Customer::POSITION_RIGHT));

                //dd([$left_childs, $right_childs]);

                $left_childs_bv = 0;
                $right_childs_bv = 0;

                if (!empty($left_childs)) {
                    $sale = DB::select(DB::raw("select sum((quantity*bv)-discount) as total_bv from sale_details where user_id IN($left_childs)"));
                    $left_childs_bv += $sale[0]->total_bv ?? 0;
                }

                if (!empty($right_childs)) {
                    $sale = DB::select(DB::raw("select sum((quantity*bv)-discount) as total_bv from sale_details where user_id IN ($right_childs)"));
                    $right_childs_bv += $sale[0]->total_bv ?? 0;
                }

                if (empty($left_childs) && empty($right_childs)) {
                    continue;
                }


                $update_is_paired_ids = array_filter(array_merge(
                    array_merge(
                        explode(',', $left_childs),
                        explode(',', $right_childs)
                    ), $update_is_paired_ids));

                //dd($update_is_paired_ids);
                //dump([$left_childs_bv, $right_childs_bv]);
                $left_childs_bv += $left_last_earning->carry_forward ?? 0;
                $right_childs_bv += $right_last_earning->carry_forward ?? 0;

//            dump(empty($right_childs) && !empty($left_childs), $user->id);
//            dump(!empty($right_childs) && empty($left_childs), $user->id);
//            dd([$left_childs_bv, $right_childs_bv]);

                if (empty($left_childs_bv) && empty($right_childs_bv)) {
                    continue;
                } elseif (empty($right_childs_bv) && !empty($left_childs_bv)) {
                    $this->noWeakerSideFound(Customer::POSITION_LEFT, $left_childs_bv, $user->id);
                    continue;
                } elseif (!empty($right_childs_bv) && empty($left_childs_bv)) {
                    $this->noWeakerSideFound(Customer::POSITION_RIGHT, $right_childs_bv, $user->id);
                    continue;
                }

                //dd([$user, $left_childs_bv, $right_childs_bv, $left_childs, $right_childs]);

                $left_points = ($left_childs_bv / 100) * $user->customer->criteria->percentage;
                $right_points = ($right_childs_bv / 100) * $user->customer->criteria->percentage;

                //dd([$user, $left_childs_bv, $right_childs_bv, $left_childs, $right_childs, $left_points, $right_points]);

                //dump($left_childs_bv < $right_childs_bv);
                $sales_bonus_detail = [];
                $carry_forward = 0;
                if (round($left_childs_bv) < round($right_childs_bv)) { // Left Weaker

                    $carry_forward = $right_childs_bv - $left_childs_bv;

                    $sales_bonus_detail = [
                        [
                            'user_id' => $user->id,
                            'sales_bonus' => $left_points,
                            'carry_forward' => 0,
                            'position' => Customer::POSITION_LEFT,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ],
                        [
                            'user_id' => $user->id,
                            'sales_bonus' => 0,
                            'carry_forward' => $carry_forward,
                            'position' => Customer::POSITION_RIGHT,
                            'created_at' => $now,
                            'updated_at' => $now,

                        ]
                    ];

                }
                //dump($right_childs_bv < $left_childs_bv);
                if (round($right_childs_bv) < round($left_childs_bv)) { //Right Weaker

                    $carry_forward = $left_childs_bv - $right_childs_bv;

                    $sales_bonus_detail = [
                        [
                            'user_id' => $user->id,
                            'sales_bonus' => $right_points,
                            'carry_forward' => 0,
                            'position' => Customer::POSITION_RIGHT,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ],
                        [
                            'user_id' => $user->id,
                            'sales_bonus' => 0,
                            'carry_forward' => $carry_forward,
                            'position' => Customer::POSITION_LEFT,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]
                    ];

                }
                //dump(['right_child_bv'=>$right_childs_bv, 'left_child_bv'=> $left_childs_bv]);
                //dump([$left_points, $right_points, !empty($carry_forward) ? $carry_forward : 'cf=0', !empty($sales_bonus_detail) ? $sales_bonus_detail : 'sales_detail=[]', $user->id]);

//            if(($left_points > 0) || ($right_points > 0)){

                if (!empty($sales_bonus_detail)) {
                    SalesBonusDetail::insert($sales_bonus_detail);
                    $this->updateEarning($user->id, ($left_points < $right_points ? $left_points : $right_points), !empty($carry_forward) ? $carry_forward : 0);
                } else {
                    //points are equal
                    $sales_bonus_detail = array(
                        [
                            'user_id' => $user->id,
                            'sales_bonus' => $left_points,
                            'carry_forward' => 0,
                            'position' => Customer::POSITION_LEFT,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ],
                        [
                            'user_id' => $user->id,
                            'sales_bonus' => 0,
                            'carry_forward' => 0,
                            'position' => Customer::POSITION_RIGHT,
                            'created_at' => $now,
                            'updated_at' => $now,

                        ]
                    );

                    SalesBonusDetail::insert($sales_bonus_detail);
                    $this->updateEarning($user->id, $left_points, 0);
                    unset($sales_bonus_detail);
                }
//            }
            }
            if (!empty($update_is_paired_ids)) {
                Customer::whereIn('user_id', $update_is_paired_ids)->update(['is_paired' => 1]);
            }

            unset($update_is_paired_ids);
            self::$user_id = NULL;
            self::$childs = NULL;
            self::$customers = NULL;
        }catch (\Exception $e){

            Log::error($e->getMessage(), [
                'File: '=>__FILE__,
                'Stack-Trace'=> $e->getTraceAsString()
            ]);
            unset($update_is_paired_ids);
            self::$user_id = NULL;
            self::$childs = NULL;
            self::$customers = NULL;
        }
    }

    public function getUplineIDs(int $parent_id){

        $this->upline = [];
        $this->getUpline($parent_id);
        return $this->upline;
    }

    private function getUpline($parent_id){

        array_push($this->upline, $parent_id);
        $parent = Customer::where('user_id', $parent_id)->first();
        if(!empty($parent)){

            if($parent->parent_id == 2){
                return false;
            }
            return $this->getUpline($parent->parent_id);
        }
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
        } else {
            self::$childs = self::$customers->where('is_paired', Customer::NOT_PAIRED)->whereIn('user_id', self::$childs)->pluck('user_id')->toArray();
        }

        return self::$childs;
    }


    /**
     * @param $user_id
     * @param $bv
     * @param $carry_forward
     * @return mixed
     */
    private function updateEarning($user_id, $bv, $carry_forward) {
        $earnings = Earning::firstOrNew(['user_id' => $user_id]);
        $earnings->sales_bonus = (float) $earnings->sales_bonus + (float) $bv;
        $earnings->carry_forward = $carry_forward;
        $earnings->earned = (float) $earnings->team_bonus + (float) $earnings->sales_bonus;
        $earnings->save();

        return $earnings;
    }


    /**
     * @param $position
     * @param $bv
     * @param $user_id
     */
    private function noWeakerSideFound($position, $bv, $user_id) {
        // use this bv as carry forward because binary tree, second leg not found.
        $now = now()->toDateTimeString();
        SalesBonusDetail::insert(array(
            [
                'user_id' => $user_id,
                'sales_bonus' => 0,
                'carry_forward' => $bv,
                'position' => $position,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => $user_id,
                'sales_bonus' => 0,
                'carry_forward' => 0,
                'position' => $position == Customer::POSITION_RIGHT ? Customer::POSITION_LEFT : Customer::POSITION_RIGHT,
                'created_at' => $now,
                'updated_at' => $now,

            ]
        ));
        $this->updateEarning($user_id, 0, $bv);
        //Log::notice('no weaker side found for user id#' .$user_id);
    }

}
