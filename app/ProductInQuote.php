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
        return $this->hasOne(Product::class);
    }

    public function quote()
    {
        return $this->hasOne(Quote::class);
    }
}
