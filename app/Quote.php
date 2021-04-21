<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    public $fillable = [
        'customer_name',
        'customer_email',
    ];

    public function products()
    {
        return $this->hasManyThrough(Product::class, ProductInQuote::class);
    }

    public function productsInQuote()
    {
        return $this->hasMany(ProductInQuote::class);
    }
}
