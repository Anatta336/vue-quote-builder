<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// ---- Product
Route::get('/products', 'ProductController@index')->name('product.index');
Route::get('/products/{product}', 'ProductController@show')->name('product.show');
Route::post('/products', 'ProductController@store')->name('product.add');
Route::patch('/products/{product}', 'ProductController@update')->name('product.update');
Route::delete('/products/{product}', 'ProductController@destroy')->name('product.delete');

// ---- Quote
Route::get('/quotes', 'QuoteController@index')->name('quote.index');
Route::get('/quotes/{quote}', 'QuoteController@show')->name('quote.show');
Route::post('/quotes', 'QuoteController@store')->name('quote.add');
Route::patch('/quotes/{quote}', 'QuoteController@update')->name('quote.update');
Route::delete('/quotes/{quote}', 'QuoteController@destroy')->name('quote.delete');

Route::post('/quotes/{quote}/email', 'QuoteController@email')->name('quote.email');

// ---- ProductInQuote
Route::get('/quotes/{quote}/products', 'ProductInQuoteController@index');

// add product to quote, where product doesn't yet exist on the quote
Route::post('/quotes/{quote}/products/{product}', 'ProductInQuoteController@store');

// remove product from the quote, whatever its count was
Route::delete('/quotes/{quote}/products/{product}', 'ProductInQuoteController@destroy');

// change count of product in quote
Route::patch('/quotes/{quote}/products/{product}', 'ProductInQuoteController@update');

