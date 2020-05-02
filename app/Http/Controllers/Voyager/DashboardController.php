<?php

namespace App\Http\Controllers\Voyager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        $view = 'vendor.voyager.dashboard.admin';
        return view($view);
    }
}
