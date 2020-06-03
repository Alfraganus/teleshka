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
Route::get('users/', 'UserController@index');
Route::post('users/create', 'UserController@create');
Route::post('users/update/{id}','UserController@update');
Route::delete('users/delete/{id}', 'UserController@destroy');
Route::get('tellies/','TellyController@index');
Route::post('tellies/create', 'TellyController@create');
Route::post('tellies/update/{id}','TellyController@update');
Route::delete('tellies/delete/{id}', 'TellyController@destroy');

Route::get('ppr/' , 'PprController@index');
Route::post('ppr/create', 'PprController@create');
Route::post('ppr/update/{id}','PprController@update');
Route::delete('ppr/delete/{id}', 'PprController@destroy');

Route::get('telly-type/', 'TellyTypeController@index');
Route::post('telly-type/create', 'TellyTypeController@create');
Route::post('telly-type/update/{id}', 'TellyTypeController@update');
Route::delete('telly-type/delete/{id}', 'TellyTypeController@destroy');