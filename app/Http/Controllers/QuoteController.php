<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateQuote;
use App\Quote;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuoteController extends Controller
{
    /**
     * Fetch a summary of all quotes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Quote::all('id', 'customer_name', 'customer_email');
    }

    /**
     * Create a new quote, with a customer name and email, but
     * no products.
     *
     * @param  \App\Http\Requests\UpdateQuote;  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateQuote $request)
    {
        $validated = $request->validated();
        $quote = new Quote($validated);
        $quote->save();

        return response('', Response::HTTP_CREATED);
    }

    /**
     * Fetch data for this quote. Includes customer name and email,
     * as well as what products are in the quote.
     *
     * Sample output (JSON):
     *  {
     *      'customer_name': 'Bob',
     *      'customer_email: 'bob@example.com',
     *      'products':
     *      {
     *          {
     *              'name': 'Plank',
     *              'count': 12,
     *              'price_pence_each': 50,
     *          },
     *          {
     *              'name': 'Nail',
     *              'count': 300,
     *              'price_pence_each': 1,
     *          }
     *      }
     *  }
     *
     * TODO: It's a bit lopsided having this list products when the
     * presence of those products is handled by ProductInQuoteController.
     *
     * @param  \App\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function show(Quote $quote)
    {
        $data['customer_name'] = $quote->customer_name;
        $data['customer_email'] = $quote->customer_email;
        $data['products'] = [];

        /** @var \App\ProductInQuote $productInQuote */
        foreach ($quote->productsInQuote() as $productInQuote) {
            $product = $productInQuote->product();
            $data['products'][] = [
                'name' => $product->name,
                'count' => $productInQuote->count,
                'price_pence_each' => $product->price_pence,
            ];
        }

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Update the quote itself changing customer details.
     * This is NOT used to update what products are in the quote,
     * see ProductInQuoteController for that functionality.
     *
     * @param  \App\Http\Requests\UpdateQuote;  $request
     * @param  \App\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuote $request, Quote $quote)
    {
        $validated = $request->validated();
        $quote->update($validated);

        return response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Delete the quote.
     *
     * @param  \App\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quote $quote)
    {
        $quote->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }
}
