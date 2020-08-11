<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReward extends Model
{
    protected $table = 'user_reward';

    protected $fillable = [
        'user_id',
        'reward_id'
    ];
}
