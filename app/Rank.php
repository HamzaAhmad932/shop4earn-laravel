<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{

    const ZERO = 1;
    const BASIC = 2;
    const STANDARD = 3;
    const SILVER = 4;
    const GOLD = 5;
    const DIAMOND = 6;

    public function customer() {
        return $this->hasMany(Customer::class);
    }
}
