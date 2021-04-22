<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductInQuote;
use App\Product;
use App\ProductInQuote;
use App\Quote;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductInQuoteController extends Controller
{
    /**
     * Fetch list of all products for a given quote.
     *
     * Sample output (JSON):
     *  [
     *      {
     *          'product_id': 1,
     *          'name': 'Plank',
     *          'price_pence': 50,
     *          'count': 12,
     *      },
     *      {
     *          'product_id': 4,
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
                'product_id' => $product->id,
                'name' => $product->name,
                'price_pence' => $product->price_pence,
                'count' => $productInQuote->count,
            ];
        }

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Add a product to the quote, only allowed when the product doesn't
     * exist on the quote.
     *
     * @param  \App\Http\Requests\UpdateProductInQuote  $request
     * @param  \App\Quote                               $productInQuote
     * @param  \App\Product                             $product
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateProductInQuote $request, Quote $quote, Product $product)
    {
        $validated = $request->validated();

        //TODO: could this be done as part of validation? (Yes)
        // Can it be added to the existing validation, without repetition?
        if ($quote->products->find($product->id)) {
            // product is already in the quote, so respond with an error
            return response([
                'data' => [
                    'errors' => [
                        'product_id' => 'Product is already part of quote.'
                    ],
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $productInQuote = new ProductInQuote([
            'count' => $validated['count'],
            'quote_id' => $quote->id,
            'product_id' => $product->id,
        ]);
        $productInQuote->save();

        return response('', Response::HTTP_CREATED);
    }

    /**
     * Update the count of a product in a quote.
     * Doesn't allow changing the product. To do that delete this
     * ProductInQuote and then add a new one.
     *
     * @param  \App\Http\Requests\UpdateProductInQuote  $request
     * @param  \App\Quote                               $productInQuote
     * @param  \App\Product                             $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductInQuote $request, Quote $quote, Product $product)
    {
        $validated = $request->validated();

        // if updating to a count of zero, instead remove
        if ($validated['count'] <= 0) {
            return $this->destroy($quote, $product);
        }

        $productInQuote = $quote->productsInQuote
            ->where('product_id', $product->id)
            ->first();
        $productInQuote->count = $validated['count'];
        $productInQuote->save();

        return response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quote $quote, Product $product)
    {
        $quote->productsInQuote
            ->where('product_id', $product->id)
            ->first()
            ->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }
}
