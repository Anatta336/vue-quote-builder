<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductInQuote;
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
     * Add a product to the quote, when the product doesn't
     * exist on the quote.
     *
     * @param  \App\Http\Requests\UpdateProductInQuote  $request
     * @param  \App\Quote                               $quote
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateProductInQuote $request, Quote $quote)
    {
        $validated = $request->validated();

        if (ProductInQuote::select()
            ->where('quote_id', $quote->id)
            ->where('product_id', $validated['product_id'])
            ->first()
        ) {
            // product is already in the quote, so respond with a validation-like error
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
            'product_id' => $validated['product_id'],
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
        // TODO?
    }

    /**
     * Update the count of a product in a quote.
     * Doesn't allow changing the product. To do that delete this
     * ProductInQuote and then add a new one.
     *
     * @param  \App\Http\Requests\UpdateProductInQuote  $request
     * @param  \App\Quote  $productInQuote
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductInQuote $request, Quote $quote)
    {
        $validated = $request->validated();
        $productInQuote = ProductInQuote::where('quote_id', $quote->id)
            ->where('product_id', $validated['product_id'])
            ->first();

        // if updating to a count of zero, instead remove
        if ($validated['count'] <= 0) {
            return $this->destroy($productInQuote);
        }

        $productInQuote->count = $validated['count'];
        $productInQuote->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductInQuote  $productInQuote
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductInQuote $productInQuote)
    {
        $productInQuote->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }
}
