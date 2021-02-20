<?php

use App\helpers\Message;
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

#----------------- -------- -----------------------------

// Form controller
// Route::group(['prefix' => 'forms'], function () {
    
//     Route::get('/', 'FormController@index');
//     Route::post('/', 'FormController@store');
//     Route::get('/{form}', 'FormController@show');
//     Route::post('/{form}', 'FormController@update');
//     Route::delete('/{form}', 'FormController@destroy');
// });

#----------------- -------- -----------------------------
// Field controller
Route::group(['prefix' => 'fields'], function () {
    
    Route::get('/', 'FieldController@index');
    Route::post('/', 'FieldController@store');
    Route::get('/{field}', 'FieldController@show');
    Route::post('/{field}', 'FieldController@update');
    Route::delete('/{field}', 'FieldController@destroy');
});

Route::any('{route}', function ($route) {
    return Message::response(false, 'Cannot find the route specified!!');
});