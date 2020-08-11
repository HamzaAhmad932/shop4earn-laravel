<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $table = 'rewards';

    public function rewarded_users(){

        return $this->belongsToMany(User::class, 'user_reward');
    }

    public function scopeTeamBonusReward($query)
    {
        return $query->where('reward_type_id', RewardType::TEAM_BONUS_REWARD_TYPE);
    }
}
