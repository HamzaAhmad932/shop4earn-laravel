<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->orderBy('products.created_at', 'DESC');
    }

    public function sub_categories(){

        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
