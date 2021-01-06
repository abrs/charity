<?php

declare(strict_types=1);

use App\Message;
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
    'middleware' => [InitializeTenancyByPath::class, 'api'],
], function () {
    #user controller actions    ----------

    #register new user
    Route::post('register', 'Api\UserController@signup');
    #login a registered user and view its details.
    Route::post('login', 'Api\UserController@login');
    
    //auth:api routes.
    Route::group(['middleware' => 'auth:api'], function () {

        #logout a logged in user
        Route::get('logout', 'Api\UserController@logout');
    });


    Route::any('{route}', function ($route) {
        return Message::response(false, "Cannot find the route {$route}!!");
    });
});
