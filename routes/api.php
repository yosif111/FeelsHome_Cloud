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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login','UserController@login');
Route::group(['middleware' => ['jwt.auth']],function(){

Route::post('/modes/add','ModesController@addMode');
Route::post('/modes/update','ModesController@editMode');
Route::delete('modes/delete/{id}','ModesController@removeMode');
Route::get('/modes/{id}','ModesController@getMode');
Route::get('/modes','ModesController@getAllModes');

});