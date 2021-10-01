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
    
});
