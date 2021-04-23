<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    public $fillable = [
        'customer_name',
        'customer_email',
    ];

    /**
     * Get all of the Products associated with this quote.
     * Note this will not provide counts for those products, for that
     * see the productsInQuote method.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
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

    /**
     * Get all of the ProductsInQuotes associated with this quote.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productsInQuote()
    {
        return $this->hasMany(ProductInQuote::class);
    }

    /**
     * Finds the total count of products in the quote.
     * e.g. 3 of productA and 2 of productB means a total count of 5.
     *
     * @return integer Total count of products in quote.
     */
    public function productCount()
    {
        return (int)$this->productsInQuote->sum('count');
    }

    /**
     * Finds the subtotal cost of this quote, in pence.
     * That is the total cost of every product in the quote,
     * without applying VAT.
     *
     * @return integer Subtotal of quote in pence.
     */
    public function subTotal() {
        // selectRaw allows the use of mathematical operators
        return (int)$this->productsInQuote()
            ->join('products', 'product_in_quotes.product_id', '=', 'products.id')
            ->selectRaw('SUM(product_in_quotes.count * products.price_pence) AS sub_total')
            ->first()->sub_total;
    }

    /**
     * Finds the VAT cost of this quote, in pence.
     * That is the VAT that will be added to the quote.
     * e.g. 100p before VAT, with VAT at 20%, vatTotal would be 20p
     *
     * @param float $vatRate VAT rate to use, e.g. 0.20 for 20% VAT.
     *
     * @return integer VAT total in pence, rounded to the nearest penny.
     */
    public function vatTotal(float $vatRate = 0.20) {
        return (int) round($this->subTotal() * $vatRate, 0);
    }

    /**
     * Calculates the grand total of this quote including VAT, in pence.
     *
     * @param float $vatRate VAT rate to use, e.g. 0.20 for 20% VAT.
     *
     * @return integer Grand total in pence, rounded to the nearest penny.
     */
    public function grandTotal(float $vatRate = 0.20) {
        return (int) round($this->subTotal() * (1.0 + $vatRate), 0);
    }
}
