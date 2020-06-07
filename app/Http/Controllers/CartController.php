<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Cart;

class CartController extends Controller
{
    public function index(Request $request){

        return view('user.cart');
    }
    public function addToCart(Request $request){

        $product = Product::find($request->id);
        $qty = $request->qty;
        $size_id = $request->size_id;
        $color_id = $request->color_id;

        Cart::add([
            'id' => $product->id,
            'product_code'=> $product->product_code,
            'product_name' => $product->product_name,
            'product_price' => $product->product_price,
            'qty' => $qty,
            'img_path'=> !empty($product->featured_img) ? $product->featured_img : '',
            'options' => [
                'size_id' => $size_id,
                'color' => $color_id
            ]
        ]);
    }
}
