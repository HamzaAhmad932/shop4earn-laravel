<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{


    public function category()
    {
        return $this->belongsToMany(Category::class);
    }
    public function productImages(){
        return $this->hasMany(ProductImage::class);
    }
}
