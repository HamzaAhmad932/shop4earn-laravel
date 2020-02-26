<?php


namespace App\Http\Traits;


use App\Rank;
use App\Customer;
use App\SaleDetail;

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

    public function updateSponsorRank(int $sponsor_id){

        $direct_sponsor_count = Customer::where([
            ['sponsor_id', '=', $sponsor_id],
            ['status', '=', Customer::STATUS_ACTIVE]
        ])->count();

        $left = Customer::where([
            ['sponsor_id', '=', $sponsor_id],
            ['position', '=', Customer::POSITION_LEFT],
            //['rank_id', '=', Rank::BASIC],
            ['status', '=', Customer::STATUS_ACTIVE],
        ])->get();

        $right = Customer::where([
            ['sponsor_id', '=', $sponsor_id],
            ['position', '=', Customer::POSITION_RIGHT],
            //['rank_id', '=', Rank::BASIC],
            ['status', '=', Customer::STATUS_ACTIVE]
        ])->get();


        $basic_level_members_in_weaker_leg = 0;

        if($left->count() > $right->count()){

            $basic_level_members_in_weaker_leg = $left->where('rank_id', Rank::BASIC)->count();
        }

        if($right->count() > $left->count()){

            $basic_level_members_in_weaker_leg = $right->where('rank_id', Rank::BASIC)->count();
        }

        $ranks = Rank::all();
        $basic_rank = $ranks->where('id', Rank::BASIC)->first();
        $standard_rank = $ranks->where('id', Rank::STANDARD)->first();
        $silver_rank = $ranks->where('id', Rank::SILVER)->first();
        $gold_rank = $ranks->where('id', Rank::GOLD)->first();
        $diamond = $ranks->where('id', Rank::DIAMOND)->first();
        $user_rank = Rank::ZERO;

        if($direct_sponsor_count >= $basic_rank->direct_referral && $basic_level_members_in_weaker_leg >= $basic_rank->required_basic){
            $user_rank = Rank::BASIC;
        }

        if($direct_sponsor_count >= $standard_rank->direct_referral && $basic_level_members_in_weaker_leg >= $standard_rank->required_basic){
            $user_rank = Rank::STANDARD;
        }

        if($direct_sponsor_count >= $silver_rank->direct_referral && $basic_level_members_in_weaker_leg >= $silver_rank->required_basic){
            $user_rank = Rank::SILVER;
        }

        if($direct_sponsor_count >= $gold_rank->direct_referral && $basic_level_members_in_weaker_leg >= $gold_rank->required_basic){
            $user_rank = Rank::GOLD;
        }

        if($direct_sponsor_count >= $diamond->direct_referral && $basic_level_members_in_weaker_leg >= $diamond->required_basic){
            $user_rank = Rank::DIAMOND;
        }

        Customer::where('user_id', $sponsor_id)->update(['rank_id' => $user_rank]);
    }

    public function giveTeamBonus($customer)
    {
        $sponsor = $customer->sponsor;
        $sponsors = $sponsor->sponsors;
        $this->deliverTeamBonus($sponsor, $sponsors);

    }

    public function deliverTeamBonus($sponsor, $sponsors){

        foreach ($sponsors as $sponsor){

        }
    }
}
