<?php


namespace App\Http\Traits;


use App\Rank;
use App\Earning;
use App\Customer;
use App\SaleDetail;
use App\Compensation;
use Illuminate\Support\Facades\Log;

trait CustomerTrait
{

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
    public function findBasicCountInLeg(int $user_id, int $rank_count = 0){

        $children = Customer::where([
            ['parent_id', '=', $user_id],
            ['status', '=', Customer::STATUS_ACTIVE],
        ])->get();

        foreach ($children as $child){
            if ($child->rank_id == Rank::BASIC){
                $rank_count ++;
            }
            return $this->findBasicCountInLeg($child->user_id, $rank_count);
        }

        return $rank_count;
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

        $left_basic_count = !empty($left->user_id) ? $this->findBasicCountInLeg($left->user_id) : 0;
        $right_basic_count = !empty($right->user_id) ? $this->findBasicCountInLeg($right->user_id) : 0;


        $basic_level_members_in_weaker_leg = 0;

        if($left_basic_count < $right_basic_count){

            $basic_level_members_in_weaker_leg = $left_basic_count;
        }

        if($right_basic_count < $left_basic_count){

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

        //dd(['direct'=>$direct_sponsor_count, 'left'=>$left, 'right'=>$right, 'basic_in_weaker'=>$basic_level_members_in_weaker_leg]);

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

    public function giveTeamBonus(Customer $customer)
    {
        $compensation = Compensation::all();
        $team_bonus_points = $customer->salesDetail->sum('tb');
        $this->teamBonusDeliver($customer, $team_bonus_points, $compensation);
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
            $earnings->team_bonus += $team_bonus;
            $earnings->earned = (float) $earnings->sales_bonus + (float) $team_bonus;
            $earnings->save();

            $level++;
            return $this->teamBonusDeliver($sponsor, $total_points, $commission_compensation, $level);
        }catch (\Exception $e){
            Log::error($e->getMessage(), ['File: '=>__FILE__, 'Team Bonus Level: '=>$level, 'User: '=>$sponsor]);
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
}
