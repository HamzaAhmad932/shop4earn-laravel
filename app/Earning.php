<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    protected $fillable = ['user_id','direct_bonus','team_bonus','sales_bonus','carry_forward','position','paid'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
