<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    const POSITION_LEFT = 1;
    const POSITION_RIGHT = 2;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected $fillable = [
        'user_id',
        'parent_id',
        'sponsor_id',
        'rank_id',
        'position',
        'is_paired',
        'status',
    ];

    public function sponsor() {
        return $this->belongsTo(Customer::class,    'sponsor_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function criteria() {
        return $this->belongsTo(BVCriteria::class, 'rank_id', 'id' );
    }

    public function rank(){
        return $this->belongsTo(Rank::class);
    }
}
