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
        $customers = Customer::with('user')->get();

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

        $childs = $customers->where('parent_id', $customer->user_id)->sortBy('position');

        $tree['extend'] = !empty($childs); // Have sub child, can extend or load sub child by ajax request (Show load more button in UI for this user)

        foreach ($childs as $child) {

            if ($level < self::LOAD_MAX_LEVEL) {

                $tree['children'][] = $this->drawTree2($child, $customers, $level);

            } else {
                break; // Stop Recursion after Required Steps Loaded.
            }
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
