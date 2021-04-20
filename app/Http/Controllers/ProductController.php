<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UpdateProduct;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Eloquent collections are automatically converted to JSON representation
        // to manually make JSON response, do something like Response::json(['name' => 'Steve');
        return Product::all(['id', 'name', 'price_pence']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProduct  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateProduct $request)
    {
        $validated = $request->validated();

        // API receives price_pounds, but it's stored as price_pence
        $validated['price_pence'] = round($validated['price_pounds'] * 100);
        unset($validated['price_pounds']);

        $created = new Product($validated);
        $created->save();

        return new Response('Product created.', 202);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //TODO
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //TODO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //TODO
    }
}
