<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Customer;
use TCG\Voyager\Facades\Voyager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GenealogyController extends Controller
{
    public function getGenealogyTree(Request $request){

        $customers = Customer::with('user')->get();
        $tree = $this->drawTree($customers->first(), $customers);

        return self::apiSuccessResponse('success', 200, $tree);
    }

    public function drawTree($customer, $customers){

        $position = $customer->position == 1 ? 'L' : 'R';
        $tree['name'] = $customer->user->name.' ('.$position.')';
        $tree['image_url'] = Voyager::image($customer->user->avatar);
        $tree['extend'] = false;

        $childs = $customers->where('parent_id', $customer->user_id);
        foreach ($childs as $child){
            $tree['children'][] = $this->drawTree($child, $customers);
        }

        return $tree;
    }
}
