<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($id=null){

        if(!empty($id)){
            $category = Category::where('id', $id)->with(['products', 'products.productImages'])->first();
            $all_categories = Category::all();
            $products = $category->products;

            return view('user.product-list', ['products'=> $products, 'all_categories'=>$all_categories]);
        }else{

            $all_categories = Category::all();
            $products = Product::with('productImages')->get();

            return view('user.product-list', ['products'=> $products, 'all_categories'=>$all_categories]);
        }
    }
}
