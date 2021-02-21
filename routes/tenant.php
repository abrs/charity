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

Route::group([
    'prefix' => '/api/{tenant}',
    'middleware' => [InitializeTenancyByPath::class, 'api'],
], function () {
    
    #user controller actions    ----------
    Route::group(['prefix' => 'users'], function () {
        
        #register new user
        Route::post('register', 'Api\UserController@signup');
        #login a registered user and view its details.
        Route::post('login', 'Api\UserController@login')->name('login');
    });

    
    //auth:api routes.
    Route::group(['middleware' => ['auth:api', 'check_expiration']], function () {

        #get all the users
        Route::get('users', 'Api\UserController@index');

        #assign role to user
        Route::post('users/assignRole', 'Api\UserController@assignRoleToUser');

        #assign type to user
        Route::post('users/assignType', 'Api\UserController@assignType');

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

        //beneficiary infos controller routes
        #create new beneficiary
        Route::post('beneficiary_infos/createNewBeneficiaryDetails', 'Api\BeneficiaryInfoController@createNewBeneficiaryDetails');
        Route::post('beneficiary_infos/assignBeneficiaryRelation', 'Api\BeneficiaryInfoController@assignBeneficiaryRelation');
        Route::post('beneficiary_infos/unAssignBeneficiaryRelation', 'Api\BeneficiaryInfoController@unAssignBeneficiaryRelation');
        Route::apiResource('beneficiary_infos', 'Api\BeneficiaryInfoController')->except('update');
        Route::post('beneficiary_infos/{beneficiary_info}', 'Api\BeneficiaryInfoController@update');

        //points routes
        Route::apiResource('points', 'Api\PointController')->except('update');
        Route::post('points/{point}', 'Api\PointController@update');
        
        //activities routes
        Route::post('activities/assignStep', 'Api\ActivityController@assignStep');
        Route::apiResource('activities', 'Api\ActivityController')->except('update');
        Route::post('activities/{activity}', 'Api\ActivityController@update');

        //steps routes
        Route::apiResource('steps', 'Api\StepController')->except('update');
        Route::post('steps/{step}', 'Api\StepController@update');

        //step approval routes
        Route::apiResource('step_approvals', 'Api\StepApprovalController')->except('update');
        Route::post('step_approvals/{step_approval}', 'Api\StepApprovalController@update');

        //locations routes
        Route::apiResource('locations', 'Api\LocationController')->except('update');
        Route::post('locations/{location}', 'Api\LocationController@update');
        
        //relations routes
        Route::apiResource('relations', 'Api\RelationController')->except('update');
        Route::post('relations/{relation}', 'Api\RelationController@update');

        //roles routes
        Route::post('roles/addPermission', 'Api\RoleController@addPermissionToRole');
        Route::post('roles/removePermission', 'Api\RoleController@removePermissionFromRole');
        Route::apiResource('roles', 'Api\RoleController')->except('update');
        Route::post('roles/{role}', 'Api\RoleController@update');

        //permissions routes
        Route::apiResource('permissions', 'Api\PermissionController')->except('update');
        Route::post('permissions/{permission}', 'Api\PermissionController@update');

        //statuses routes
        Route::apiResource('statuses', 'Api\StatusController')->except('update');
        Route::post('statuses/{status}', 'Api\StatusController@update');

        //Form
        Route::group(['prefix' => 'forms'], function () {
            
            Route::get('/', 'Api\FormController@index');
            Route::post('/', 'Api\FormController@store');
            Route::post('/submit','Api\FormController@submitForm');
            Route::get('/{form}', 'Api\FormController@show');
            Route::post('/{form}', 'Api\FormController@update');
            Route::delete('/{form}', 'Api\FormController@destroy');
        });
        Route::get('/beneficiary_forms', 'Api\FormController@showAllBeneficiaryForm');
        Route::get('/beneficiary_forms/{id}', 'Api\FormController@showByUserId');
        Route::get('/beneficiary_forms', 'Api\FormController@showWaitingBeneficiaryForm');
        Route::get('/approved_custodian_beneficiary_forms', 'Api\FormController@showCustodianApprovedBeneficiaryForm');
        Route::post('/beneficiary_decision', 'Api\FormController@beneficiaryDecision');
    });

    

    Route::any('{route}', function ($route) {
        return Message::response(false, "Cannot find the route [{$route}]!!");
    });
});
