<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductInQuote extends Model
{
    public $fillable = [
        'quote_id',
        'product_id',
        'count',
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function quote()
    {
        return $this->hasOne(Quote::class, 'id', 'quote_id');
    }

    /**
     * Finds the total cost of this product, in pence.
     * Simply multiplies the product's cost with its count.
     *
     * @return number Total cost of this product, in pence.
     */
    public function linePrice()
    {
        return (int)$this->product->price_pence * $this->count;
    }
}
