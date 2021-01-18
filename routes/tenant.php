<?php

declare(strict_types=1);

use App\Helpers\Message;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

// Route::middleware([
//     'api',
//     InitializeTenancyByPath::class,
    
//     PreventAccessFromCentralDomains::class,
// ])->group(function () {
    
//     #user controller actions    ----------

//     #register new user
//     Route::post('register', 'Api\UserController@signup');
//     #ligin a registered user and view its details.
//     Route::post('login', 'Api\UserController@login');

// });

Route::group([
    'prefix' => '/api/{tenant}',
    'middleware' => [InitializeTenancyByPath::class, 'api', PreventAccessFromCentralDomains::class],
], function () {
    
    #user controller actions    ----------
    Route::group(['prefix' => 'users'], function () {
        
        #register new user
        Route::post('register', 'Api\UserController@signup');
        #login a registered user and view its details.
        Route::post('login', 'Api\UserController@login')->name('login');
    });

    
    //auth:api routes.
    Route::group(['middleware' => 'auth:api'], function () {

        #get all the users
        Route::get('users', 'Api\UserController@index');

        #logout a logged in user
        Route::get('logout', 'Api\UserController@logout');

        //types controller routes
        Route::apiResource('types', 'Api\TypeController')->except('update');
        Route::post('types/{type}', 'Api\TypeController@update');

        //type infos controller routes
        Route::apiResource('type_infos', 'Api\TypeInfoController')->except('update');
        Route::post('type_infos/{type_info}', 'Api\TypeInfoController@update');

        //party infos controller routes
        #create new party
        Route::post('party_infos/createNewParty', 'Api\PartyInfoController@createNewParty');
        Route::apiResource('party_infos', 'Api\PartyInfoController')->except('update');
        Route::post('party_infos/{party_info}', 'Api\PartyInfoController@update');
    });


    Route::any('{route}', function ($route) {
        return Message::response(false, "Cannot find the route [{$route}]!!");
    });
});
