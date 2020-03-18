<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $featured_products = Product::with(['category', 'productImages'])->orderBy('created_at', 'DESC')->take(6)->get();
        //dd($featured_products);
        return view('user.home', [
            'featured_products'=> $featured_products
        ]);
    }
}
