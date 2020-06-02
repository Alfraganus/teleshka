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

Route::post('users/login', 'UserController@login');
Route::post('users/register', 'UserController@register');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('users/', 'UserController@index');
Route::post('users/create', 'UserController@create');
Route::post('users/update/id','UserController@update');
Route::delete('users/delete/id', 'UserController@destroy');
Route::get('tellies/','TellyController@index');
Route::post('users/update/id','TellyController@update');
Route::post('tellies/create', 'TellyController@create');
Route::post('tellies/update','TellyController@update');
Route::delete('tellies/delete/{id}', 'TellyController@destroy');
