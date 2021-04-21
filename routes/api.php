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
Route::get('/product', 'ProductController@index')->name('product.index');
Route::get('/product/{product}', 'ProductController@show')->name('product.show');
Route::post('/product', 'ProductController@store')->name('product.add');
Route::patch('/product/{product}', 'ProductController@update')->name('product.update');
Route::delete('/product/{product}', 'ProductController@destroy')->name('product.delete');


// ---- Quote
Route::get('/quote', 'QuoteController@index')->name('quote.index');
Route::get('/quote/{quote}', 'QuoteController@show')->name('quote.show');
Route::post('/quote', 'QuoteController@store')->name('quote.add');
Route::patch('/quote/{quote}', 'QuoteController@update')->name('quote.update');
Route::delete('/quote/{quote}', 'QuoteController@destroy')->name('quote.delete');

// ---- ProductInQuote
Route::get('/quote/{quote}/products', 'ProductInQuoteController@index');

// add product to quote, where product doesn't yet exist on the quote
Route::post('/quote/{quote}', 'ProductInQuoteController@store');

// change count of product in quote
Route::patch('/quote/{quote}/products', 'ProductInQuoteController@update');
