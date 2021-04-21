<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductInQuote;
use App\Quote;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductInQuoteController extends Controller
{
    /**
     * Fetch list of all products for a given quote.
     *
     * Sample output (JSON):
     *  [
     *      {
     *          'name': 'Plank',
     *          'price_pence': 50,
     *          'count': 12,
     *      },
     *      {
     *          'name': 'Nail',
     *          'price_pence': 1,
     *          'count': 300,
     *      }
     *  ]
     *
     * @param  \App\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function index(Quote $quote)
    {
        $data = [];

        /** @var \App\ProductInQuote $productInQuote */
        foreach ($quote->productsInQuote()->get() as $productInQuote) {
            $product = $productInQuote->product()->first();
            $data[] = [
                'name' => $product->name,
                'price_pence' => $product->price_pence,
                'count' => $productInQuote->count,
            ];
        }

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Add a product to the quote, when the product doesn't
     * exist on the quote.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quote                $quote
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Quote $quote)
    {
        //TODO: this should surely be in a dedicated validation class
        $product = DB::table('products')->find($request->input('product_id'));
        if (empty($product)) {
            return response([
                'data' => [
                    'errors' => [
                        'product_id' => 'Product not found.'
                    ],
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (DB::table('product_in_quotes')
            ->where('quote_id', $quote->id)
            ->where('product_id', $product->id)
            ->first('id')
        ) {
            // product is already in the quote
            return response([
                'data' => [
                    'errors' => [
                        'product_id' => 'Product is already part of quote.'
                    ],
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $productInQuote = new ProductInQuote([
            'count' => $request->input('count'),
            'quote_id' => $quote->id,
            'product_id' => $product->id,
        ]);
        $productInQuote->save();

        return response('', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductInQuote  $productInQuote
     * @return \Illuminate\Http\Response
     */
    public function show(ProductInQuote $productInQuote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductInQuote  $productInQuote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductInQuote $productInQuote)
    {
        //TODO: if update to a count of zero, instead remove
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductInQuote  $productInQuote
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductInQuote $productInQuote)
    {
        //
    }
}
