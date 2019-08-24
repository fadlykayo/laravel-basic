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

Route::get("/", function () {
    return view("welcome");
});

// Notes:
// prefix untuk route url
// name untuk nama di view
// compact("id") sama dengan ["id" => $id]
// versi lengkap nya Route::get("product/", "Web\ProductController@index")->name("products.index");

// Kalo mau automatisasi:
// php artisan make:controller --resource Web/ArticleController
// php -S localhost:9000 -t public

Route::namespace("Web") //karena kita ada di dalam folder Web di folder Controllers
->group(function () {
    Route::name("product.")
    ->prefix("products")
    ->group(function () {
        Route::get("/", "ProductController@index")->name("index"); // Web\ProductController diwakili oleh namespace; @index itu function index
        Route::post("/", "ProductController@store")->name("store");
        Route::put("{id}/", "ProductController@update")->name("update");
        Route::delete("{id}/", "ProductController@destroy")->name("destroy");
        Route::get("create/", "ProductController@create")->name("create");
        Route::get("{id}/edit/", "ProductController@edit")->name("edit");
        Route::get("{id}/", "ProductController@show")->name("show");
    });

    // Route::resource("comments", "CommentController");
    // Route::resources([
    //     "articles" => "ArticleController",
    //     "comments" => "CommentController",
    // ]);
});

// Notes:
// index    GET      /
//
// create   GET     /create
// store    POST    /
//
// edit     GET     /{id}/edit
// update   PUT     /{id}
//
// delete   DELETE  /{id}
//
// show     GET     /{id}
