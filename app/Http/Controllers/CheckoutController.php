<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use App\Customer;
use App\SaleDetail;
use App\CustomSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CheckoutRequest;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    public function index(Request $request){

        return view('user.checkout');
    }

    public function checkout(CheckoutRequest $request)
    {

        $cart = Cart::instance('shopping')->content();
        if(!$cart->isEmpty()){

            $sponsor_id = $request->sponsor_id;
            if(empty($sponsor_id)){
                $sponsor_id = CustomSetting::find(1)->default_sponsor_id;
            }

            $user = User::create([
                'name' => $request->name,
                'email' =>  $request->email,
                'password' => Hash::make($request->password),
                'role_id'=> User::CUSTOMER_ROLE,
                'city'=> $request->city,
                'mobile'=> $request->phone,
            ]);

            $customer =  Customer::create([
                'user_id' => $user->id,
                'parent_id' => 0, //parent id will be assigned at user activation
                'sponsor_id' => 0,
                'rank_id' => 1, //zero level by default
                'position' => $request->position,
                'is_paired' => 1, // is paired status will be 1 because sales bonus job ignore this entry
                'status'=> Customer::STATUS_INACTIVE,
                'temp_sponsor_id'=> $sponsor_id
            ]);

            if ($customer) {
                $user->update(['customer_id'=> $customer->id]);
                $this->createSaleDetail($customer, $cart);
                //make cart empty
                Cart::instance('shopping')->destroy();
                return self::apiSuccessResponse('Order placed successfully.', 200, route('thanks'));
            }

        }else{
            return self::apiErrorResponse('You did not select any product for checkout.', 422);
        }
    }

    public function createSaleDetail(Customer $customer, $cart)
    {
        $bulk_sale = [];
        $product_ids = array_column($cart->toArray(), 'id');
        $products = Product::whereIn('id', $product_ids)->get();

        foreach ($cart as $p){
            $product = $products->where('id', $p->id)->first();
            $sale = [
                'user_id' => $customer->user_id,
                'product_id' => $product->id,
                'product_code' => $product->product_code,
                'product_price' => abs($product->product_price),
                'pv' => $product->pv,
                'bv' => $product->bv,
                'tb' => $product->tb,
                'color_id' => 0,
                'size_id' => 0,
                'quantity' => $p->qty,
                'discount' => $product->discount,
                'IP' => Request()->ip(),
                'created_at'=> now()->toDateTimeString(),
                'updated_at'=> now()->toDateTimeString(),
            ];
            array_push($bulk_sale, $sale);
        }

        return SaleDetail::insert($bulk_sale);
    }
}
