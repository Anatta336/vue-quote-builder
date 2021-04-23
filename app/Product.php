<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable = [
        'name',
        'price_pence',
    ];

    /**
     * Get all the quotes that this product is used in.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function quotes()
    {
        return $this->hasManyThrough(
            Quote::class,
            ProductInQuote::class,
            'product_id', // foreign key on intermediate
            'id',         // foreign key on final
            'id',         // local key
            'quote_id',   // local key on intermediate
        );
    }

    /**
     * Get all of the ProductsInQuotes associated with this product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productsInQuote()
    {
        return $this->hasMany(ProductInQuote::class);
    }
}
