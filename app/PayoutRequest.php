<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayoutRequest extends Model
{
    const PENDING_STATUS = 0;
    const PAID_STATUS = 1;
    const REJECTED_STATUS = 2;

    protected $fillable = [
        'user_id',
        'customer_id',
        'payment_method_id',
        'amount',
        'phone',
        'donation',
        'admin_percentage',
        'admin_charges',
        'payable_amount',
        'status',
        'date_requested',
        'date_cleared'
    ];
}
