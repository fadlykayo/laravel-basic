<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Notes:
// prefix untuk route url
// name untuk nama di view
// compact('id') sama dengan ['id' => $id]
// versi lengkap nya Route::get('product/', 'Web\ProductController@index')->name('products.index');

// Kalo mau automatisasi:
// php artisan make:controller --resource Web/ArticleController

Route::namespace('Web')
->group(function () {
    Route::name('products.')
    ->prefix('products')
    ->group(function () {
        Route::get('/', 'ProductController@index')->name('index');
        Route::get('create/', 'ProductController@create')->name('create');
        Route::get('{id}/', 'ProductController@show')->name('show');
    });

    // Route::resource('comments', 'CommentController');
    
    Route::resources([
        'articles' => 'ArticleController',
        'comments' => 'CommentController',
    ]);
});
