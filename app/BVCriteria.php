<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BVCriteria extends Model
{
    public function customer() {
        return $this->hasMany(Customer::class, 'rank_id','rank_id');
    }
}
