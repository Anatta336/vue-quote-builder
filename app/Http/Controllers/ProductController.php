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
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // could just return $product which will JSONify all its properties,
        // but want to only provide specific data.
        return response()
            ->json([
                'id' => $product->id,
                'name' => $product->name,
                'price_pence' => $product->price_pence,
            ])
            -> setStatusCode(Response::HTTP_OK);
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
        $this->pricePoundsToPence($validated);

        $created = new Product($validated);
        $created->save();

        return response('', Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProduct  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProduct $request, Product $product)
    {
        $validated = $request->validated();
        $this->pricePoundsToPence($validated);

        $product->update($validated);

        return response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Modifies the given array (which is passed by reference) to remove the
     * 'price_pounds' value on it, and add a 'price_pence' using that value.
     *
     * @param array $data Validated data as an associative array that includes
     *                    'prince_pounds' as a key.
     *
     * @return void
     */
    protected function pricePoundsToPence(&$data) {
        $data['price_pence'] = round($data['price_pounds'] * 100);
        unset($data['price_pounds']);
    }
}
