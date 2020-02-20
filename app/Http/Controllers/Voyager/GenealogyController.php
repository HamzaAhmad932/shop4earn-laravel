<?php

namespace App\Http\Controllers\Voyager;

use TCG\Voyager\Facades\Voyager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GenealogyController extends \TCG\Voyager\Http\Controllers\VoyagerBaseController
{

    public function index(Request $request)
    {

        $view = 'vendor.voyager.genealogy-tree.browse';
        return view($view);
    }
}
