<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends \TCG\Voyager\Models\User
{

    use Notifiable;

    const SUPER_ADMIN_ROLE = 1;
    const SUB_ADMIN_ROLE = 4;
    const CUSTOMER_ROLE = 3;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'customer_id', 'city', 'mobile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sponsor() {
        return $this->hasMany(Customer::class,    'sponsor_id', 'id');
    }

    public function child_sponsor() {
        return $this->hasMany(Customer::class,    'parent_id', 'id');
    }

    public function earning(){
        return $this->hasOne(Earning::class);
    }

    public function salesBonusDetail(){
        return $this->hasMany(SalesBonusDetail::class);
    }

    public function customer(){
        return $this->hasOne(Customer::class);
    }

}
