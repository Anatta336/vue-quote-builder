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
}
