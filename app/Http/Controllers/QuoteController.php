<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateQuote;
use App\Mail\QuoteToCustomer;
use App\Quote;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

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
     * Fetch data for this quote. Provides customer name and email,
     * if the products are needed then use ProductInQuoteController.
     *
     * @param  \App\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function show(Quote $quote)
    {
        return response()->json([
            'id' => $quote->id,
            'customer_name' => $quote->customer_name,
            'customer_email' => $quote->customer_email,
        ])-> setStatusCode(Response::HTTP_OK);
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

    public function email(Quote $quote)
    {
        Mail::to($quote->customer_email)->send(new QuoteToCustomer($quote));

        return response('I guess that sent an email, maybe!');
    }
}

