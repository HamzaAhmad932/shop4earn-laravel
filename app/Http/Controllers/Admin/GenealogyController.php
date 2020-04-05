<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Customer;
use TCG\Voyager\Facades\Voyager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GenealogyController extends Controller
{

    public const LOAD_MAX_LEVEL = 3;

    public function getGenealogyTree(Request $request) {

        $user = Auth::user();
        $customers = Customer::with('user', 'sponsor')->get();

        if (!empty($request->user_id)) { //Ajax Reload next levels

            $first_customer = $customers->where('user_id', $request->user_id)->first();

        } else { // Load first 4 level child.

            $first_customer =
                $user->role_id == User::CUSTOMER_ROLE
                    ? $customers->where('user_id', $user->id)->first()
                    : $customers->first();
        }

        $tree = $this->drawTree2($first_customer, $customers,0);

        return self::apiSuccessResponse('success', 200, $tree);
    }


    /**
     * Pass Parent Customer it will return all left and right childs 4 levels below.
     * for next levels childs pass last parent to get its next 4 level childs.
     * extend = 'true' if user has sub child in Database else false if this user not have any sub child.
     * @param $customer
     * @param $customers
     * @param int $level
     * @return mixed
     */
    public function drawTree2($customer, $customers, $level = 0)
    {

        $level++;

        $position = $customer->position == 1 ? 'L' : 'R';

        $tree['level'] = $level;
        $tree['user_id'] = $customer->user_id;
        $tree['name'] = $customer->user->name.' ('.$position.')';
        $tree['image_url'] = Voyager::image($customer->user->avatar);
        $tree['extend'] = $level < self::LOAD_MAX_LEVEL; // Have sub child, can extend or load sub child by ajax request (Show load more button in UI for this user)
        $tree['show_extend'] = true;
        $tree['sponsor'] = !empty($customer->sponsor) ? $customer->sponsor->user->name.' ('.$customer->sponsor_id.')' : '('.$customer->sponsor_id.')';
        $tree['user_name'] = $customer->user->name;
        $tree['clickable'] = false;
        $tree['position'] = $customer->position;

        $childs = $customers->where('parent_id', $customer->user_id)->sortBy('position');

        foreach ($childs as $child) {

            if ($level < self::LOAD_MAX_LEVEL) {

                $tree['children'][] = $this->drawTree2($child, $customers, $level);

            } else {
                break; // Stop Recursion after Required Steps Loaded.
            }
        }

        if($childs->count() == 1){
            //dd($childs);
            $first = $childs->first();
            $pos = $first->position == 1 ? 'R' : 'L';
            $pos_id = $first->position == 1 ? 2 : 1;
            $index = $first->position == 1 ? 1 : 0;
            if(!empty($tree['children']) && array_key_exists($index, $tree['children'])){
                $index = $index == 0 ? 1 : 0;
            }

            $tree['children'][$index]['level'] = '';
            $tree['children'][$index]['user_id'] = '';
            $tree['children'][$index]['position'] = $pos_id;
            $tree['children'][$index]['name'] = 'Add User'.' ('.$pos.')';
            $tree['children'][$index]['sponsor'] = '';
            $tree['children'][$index]['user_name'] = '';
            $tree['children'][$index]['image_url'] = asset('/assets/images/plus_icon.png');
            $tree['children'][$index]['extend'] = false;
            $tree['children'][$index]['show_extend'] = false;
            $tree['children'][$index]['clickable'] = true;
            $tree['children'][$index]['parent_id'] = $customer->user_id;
            //sort($tree['children']);
            if($first->position == 2 && $tree['children'][0]['user_id'] != ''){
                //dump([$tree['children'], sort($tree['children'])]);
                sort($tree['children']);
            }

        }

        if($childs->count() == 0){
            $tree['children'][0]['level'] = '';
            $tree['children'][0]['user_id'] = '';
            $tree['children'][0]['position'] = 1;
            $tree['children'][0]['name'] = 'Add User (L)';
            $tree['children'][0]['sponsor'] = '';
            $tree['children'][0]['user_name'] = '';
            $tree['children'][0]['image_url'] = asset('/assets/images/plus_icon.png');
            $tree['children'][0]['extend'] = false;
            $tree['children'][0]['show_extend'] = false;
            $tree['children'][0]['clickable'] = true;
            $tree['children'][0]['parent_id'] = $customer->user_id;

            $tree['children'][1]['level'] = '';
            $tree['children'][1]['user_id'] = '';
            $tree['children'][1]['position'] = 2;
            $tree['children'][1]['name'] = 'Add User (R)';
            $tree['children'][1]['sponsor'] = '';
            $tree['children'][1]['user_name'] = '';
            $tree['children'][1]['image_url'] = asset('/assets/images/plus_icon.png');
            $tree['children'][1]['extend'] = false;
            $tree['children'][1]['show_extend'] = false;
            $tree['children'][1]['clickable'] = true;
            $tree['children'][1]['parent_id'] = $customer->user_id;
        }

        return $tree;
    }


    /**
     *  public function drawTree($customer, $customers, $turn = 0){
    $position = $customer->position == 1 ? 'L' : 'R';
    $tree['user_id'] = $customer->user_id;
    $tree['name'] = $customer->user->name.' ('.$position.')';
    $tree['image_url'] = Voyager::image($customer->user->avatar);
    $tree['extend'] = true;

    $childs = $customers->where('parent_id', $customer->user_id)->sortBy('position');
    foreach ($childs as $child){
    $tree['children'][] = $this->drawTree($child, $customers, $turn);
    }

    return $tree;
    }
     */

}
