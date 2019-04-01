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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::post('user/login', 'api\v1\User\UserController@login');
Route::post('user/register', 'api\v1\User\UserController@register');
Route::get('user/show/{id}', 'api\v1\User\UserController@show');

//Route::group(['middleware' => 'auth:api'], function(){

	
	Route::put('user/update/{id}', 'api\v1\User\UserController@update');
	Route::post('business/register', 'api\v1\Business\BusinessController@register');
	Route::post('business/show/{id}', 'api\v1\Business\BusinessController@show');
	Route::put('business/update/{id}', 'api\v1\Business\BusinessController@update');
	Route::post('category/create', 'api\v1\Category\CategoryController@create');
	Route::post('category/show/{id}', 'api\v1\Category\CategoryController@show');
	Route::put('category/update/{id}', 'api\v1\Category\CategoryController@update');
	Route::put('category/destroy/{id}', 'api\v1\Category\CategoryController@destroy');

//});