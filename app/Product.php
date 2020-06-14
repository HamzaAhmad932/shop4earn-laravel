<?php

namespace App;

use App\Category;
use TCG\Voyager\Traits\Resizable;
use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Contracts\Buyable;

class Product extends Model implements Buyable
{
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function category()
    {
        return $this->belongsToMany(Category::class);
    }
    public function productImages(){
        return $this->hasMany(ProductImage::class);
    }

    /**
     * @inheritDoc
     */
    public function getBuyableIdentifier($options = null)
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getBuyableDescription($options = null)
    {
        return $this->product_name;
    }

    /**
     * @inheritDoc
     */
    public function getBuyablePrice($options = null)
    {
        return $this->product_price;
    }
}
