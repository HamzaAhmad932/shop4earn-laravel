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
    public function getGenealogyTree(Request $request){

        $user = Auth::user();
        $customers = Customer::with('user')->get();

        $first_customer = $user->role_id == User::CUSTOMER_ROLE ? $customers->where('user_id', $user->id)->first() : $customers->first();

        $tree = $this->drawTree($first_customer, $customers);

        return self::apiSuccessResponse('success', 200, $tree);
    }

    public function drawTree($customer, $customers){

        $position = $customer->position == 1 ? 'L' : 'R';
        $tree['name'] = $customer->user->name.' ('.$position.')';
        $tree['image_url'] = Voyager::image($customer->user->avatar);
        $tree['extend'] = true;

        $childs = $customers->where('parent_id', $customer->user_id);
        foreach ($childs as $child){
            $tree['children'][] = $this->drawTree($child, $customers);
        }

        return $tree;
    }
}
