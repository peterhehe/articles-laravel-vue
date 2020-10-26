<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/article', 'ArticlesController@create');
Route::get('/article/{article_name}', 'ArticlesController@getPublishedArticle');
Route::get('/article/{id}/update', 'ArticlesController@getArticleForUpdate');
Route::patch('/article/{id}/update', 'ArticlesController@edit');
Route::get('/articles', 'ArticlesController@getArticles');
Route::delete('/article/{id}/delete', 'ArticlesController@destroy');
