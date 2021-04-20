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

Route::get('/product', 'ProductController@index')
    ->name('product.index');

Route::post('/product', 'ProductController@store')
    ->name('product.add');

Route::get('/product/{product}', 'ProductController@show')
    ->name('product.show');

Route::put('/product/{product}', 'ProductController@update')
    ->name('product.update');

Route::delete('/product/{product}', 'ProductController@destroy')
    ->name('product.delete');
