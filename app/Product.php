<?php

namespace App;

use App\Category;
use TCG\Voyager\Traits\Resizable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Resizable;

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }
    public function productImages(){
        return $this->hasMany(ProductImage::class);
    }
}
