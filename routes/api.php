<?php

use Illuminate\Http\Request;

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
Route::group([
    'prefix'=>'user',
    'namespace'=>'User',
],
function(){
    Route::post('register','AuthController@register');
    Route::post('login','AuthController@login');

    Route::get("product/get-all/{token}/{pagination?}","ProductController@getPaginatedData");
    Route::get("product/search/{search}/{token}/{pagination?}","ProductController@searchData");
    Route::post("product/order/{id}/{token}","ProductController@order_product");
    Route::get("product-details/{id}","ProductController@product_details");

    Route::get("order/get-all/{token}/{pagination?}","OrderController@getPaginatedData");
    Route::get("order/search/{search}/{token}/{pagination?}","OrderController@searchData");
    Route::get("single-order/{id}","OrderController@getSingleData");
    Route::post("order/update/{id}","OrderController@editSingleData");
    Route::get("edit-orders/{id}/{pagination?}","OrderController@getPaginatedEditData");
    Route::post("delete-order/{id}","OrderController@deleteOrder");

});

  