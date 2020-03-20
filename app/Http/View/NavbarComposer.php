<?php

namespace App\Http\View\Composers;

use App\Category;
use Illuminate\View\View;

class NavbarComposer
{

    public function __construct()
    {

    }

    public function compose(View $view)
    {
        $p_cats = Category::with([
            'sub_categories'
        ])->where('parent_id', null)->get();
        $view->with('navbar', $p_cats);
    }

    public function create(View $view)
    {
        $p_cats = Category::with([
            'sub_categories'
        ])->where('parent_id', null)->get();
        $view->with('navbar', $p_cats);
    }
}
