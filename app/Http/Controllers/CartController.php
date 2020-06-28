<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index(Request $request){

        return view('user.cart');
    }
    public function addToCart(Request $request){


        $this->validate($request, [
            'product_id' => 'required|numeric',
            'qty' => 'required|numeric',
            //'size_id' => '',
            //'color_id' => ''
        ]);

        $product = Product::find($request->product_id);
        $qty = $request->qty;
        //$size_id = $request->size_id;
        //$color_id = $request->color_id;

        Cart::instance('shopping')->add($product, $qty, ['image_path'=> Voyager::image($product->featured_img)]);

        return redirect()->route('cart.show');

    }

    private function shoppingCartContent(){
        return response()->json([
            'cart_content'=> Cart::instance('shopping')->content(),
            'totals'=> [
                'sub_total'=> Cart::instance('shopping')->subtotal(),
                'total'=> Cart::instance('shopping')->total()
            ]
        ]);
    }

    public function getShoppingCartContent(Request $request)
    {
        return $this->shoppingCartContent();
    }

    public function updateShoppingCartContent(Request $request){

        $this->validate($request, [
            'row_id'=> 'required',
            'qty'=> 'required|numeric'
        ]);

        Cart::instance('shopping')->update($request->row_id, $request->qty);

        return $this->shoppingCartContent();
    }

    public function deleteShoppingCartItem(Request $request){

        $this->validate($request, [
            'row_id'=> 'required',
        ]);

        Cart::instance('shopping')->remove($request->row_id);

        return $this->shoppingCartContent();
    }
}
