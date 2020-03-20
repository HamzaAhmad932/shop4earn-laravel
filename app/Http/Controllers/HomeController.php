<?php

namespace App\Http\Controllers;

use App\Slider;
use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

//        $featured_products = Product::with(['category', 'productImages'])->orderBy('created_at', 'DESC')->take(6)->get();
        $slider = Slider::where('type', 1)->get();
        //dd($featured_products);
        return view('user.home', [
            'slider'=>$slider
//            'featured_products'=> $featured_products
        ]);
    }
}
