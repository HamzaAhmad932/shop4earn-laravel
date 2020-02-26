<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    public function customer(){
        return $this->belongsTo(Customer::class, 'user_id', 'user_id');
    }
}
