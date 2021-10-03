<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'admin', 'namespace'=>'Admin'], function() {

	Route::get('dashboard', 'HomeController@dashboard')->name('home.index');

  Route::resource('/products', 'ProductController',  [
      'names' => [
          'create' => 'products.create',
          'edit' => 'products.edit',
          'show' => 'products.show',
      ]])->only(['create', 'edit', 'show']);

  Route::match(['get', 'post'], '/products', 'ProductController@index')->name('products');
  Route::post('/products/store', 'ProductController@store')->name('products.store');
  Route::match(['get', 'post'], '/products/delete/{id}', 'ProductController@destroy')
      ->where(['id'=>'[0-9]+'])->name('products.delete');

  Route::resource('/orders', 'OrderController',  [
      'names' => [
          'create' => 'orders.create',
          'edit' => 'orders.edit',
      ]])->only(['create', 'edit']);

  Route::match(['get', 'post'], '/orders', 'OrderController@index')->name('orders');
  Route::post('/orders/store', 'OrderController@store')->name('orders.store');
  Route::match(['get', 'post'], '/orders/delete/{id}', 'OrderController@destroy')
      ->where(['id'=>'[0-9]+'])->name('orders.delete');
    
});
