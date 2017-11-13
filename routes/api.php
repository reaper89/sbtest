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

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

/* Route group which goes through the Laravel API middleware */

Route::middleware('auth:api')->group(function(){

    Route::get('/shoes/{id}/tags', 'TagsController@index');
    Route::resource('shoes', 'ShoesController', ['only' => ['index', 'show', 'store', 'destroy']]);
    Route::resource('tags', 'TagsController', ['only' => 'show']);

});


