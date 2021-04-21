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
        return $this->hasManyThrough(
            Product::class,
            ProductInQuote::class,
            'quote_id',   // foreign key on intermediate
            'id',         // foreign key on final
            'id',         // local key
            'product_id', // local key on intermediate
        );
    }

    public function productsInQuote()
    {
        return $this->hasMany(ProductInQuote::class);
    }
}
