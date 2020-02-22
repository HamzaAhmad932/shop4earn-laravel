<?php

namespace App\Widgets;

use App\User;
use App\Earning;
use App\Customer;
use TCG\Voyager\Widgets\BaseDimmer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class CustomerRank extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $customer = Auth::user()->customer;
        $rank = !empty($customer) ? $customer->rank->rank_name : 'Member';
        $string = 'Rank';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon' => 'voyager-diamond',
            'title' => "{$string} : {$rank}",
//            'text' => __('voyager::dimmer.post_text', ['count' => $count, 'string' => Str::lower($string)]),
            'text' => '',
            'button' => [
                'text' => 'View',
                'link' => '',
            ],
            'image' => voyager_asset('images/widget-backgrounds/02.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return Auth::user()->role_id == User::CUSTOMER_ROLE;
    }
}
