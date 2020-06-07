<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($id=null){

        $all_categories = Category::all();

        if(!empty($id)){
            $category = Category::where('id', $id)->with(['products'])->first();
            $products = $category->products;

            return view('user.product-list-2', ['products'=> $products, 'all_categories'=>$all_categories]);
        }else{

            $products = Product::all();

            return view('user.product-list-2', ['products'=> $products, 'all_categories'=>$all_categories]);
        }
    }

    public function productDetail(Request $request){

        $products = Product::all();
        $all_categories = Category::all();
        $product = $products->where('id', $request->id)->first();

        return view('user.product-detail-2', [
            'product'=> $product,
            'all_categories'=>$all_categories,
            'products'=> $products
        ]);
    }

    public function cart(Request $request){

    }
}
