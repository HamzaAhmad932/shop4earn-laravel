<?php

namespace App\Widgets;

use App\User;
use App\Earning;
use App\Customer;
use TCG\Voyager\Widgets\BaseDimmer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class TeamBonus extends BaseDimmer
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
        $earning = Earning::where('user_id', Auth::user()->id)->first();
        $bonus = !empty($earning) ? $earning->team_bonus : 0;
        $string = 'Team Bonus';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon' => 'voyager-milestone',
            'title' => "{$string} : {$bonus}",
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
