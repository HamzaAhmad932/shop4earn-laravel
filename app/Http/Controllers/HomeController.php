<?php

namespace App\Http\Controllers;

use App\Slider;
use App\Product;
use App\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $special_offers = Category::with(['products', 'products.productImages'])->where('parent_id', null)->take(5)->get();

        $slider = Slider::where('type', 1)->get();
        $banners = Slider::where('type', 2)->get();
        $our_products = Product::with('categories')->take(20)->get();

        return view('user.home', [
            'slider'=>$slider,
            'banners'=>$banners,
            'special_offers'=> $special_offers,
            'our_products'=> $our_products
        ]);
    }
}
