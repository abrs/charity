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

        Route::prefix('users')->group(function () {
            
            #assign user a location
            Route::post('assignUserLocation', 'Api\UserController@assignUserLocation');
            #assign user a phone
            Route::post('assignUserPhone', 'Api\UserController@assignUserPhone');
            #assign user a relation
            Route::post('assignUserRelation', 'Api\UserController@assignUserRelation');
            #un-assign user a relation
            Route::post('unAssignUserRelation', 'Api\UserController@unAssignUserRelation');
            #getAllUsersBelongsToType
            Route::post('getAllUsersBelongsToType', 'Api\UserController@getAllUsersBelongsToType');
            #getAllTheBeneficiariesUsers
            Route::get('getAllTheBeneficiariesUsers', 'Api\UserController@getAllTheBeneficiariesUsers');
            #getUserProfile
            Route::post('getProfile', 'Api\UserController@getProfile');
            
        });

        #get all the users
        Route::get('users', 'Api\UserController@index');

        #assign role to user
        Route::post('users/assignRole', 'Api\UserController@assignRoleToUser');

        #assign type to user
        Route::post('users/assignType', 'Api\UserController@assignType');

        #logout a logged in user
        Route::post('users/logout', 'Api\UserController@logout');

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

        //beneficiary_types
        Route::apiResource('beneficiary_types', 'Api\BeneficiaryTypeController')->except('update');
        Route::post('beneficiary_types/{beneficiary_type}', 'Api\BeneficiaryTypeController@update');

        //beneficiary infos controller routes
        #create new beneficiary
            

        Route::post('beneficiary_infos/changeAcceptanceType', 'Api\BeneficiaryInfoController@changeAcceptanceType');
        Route::post('beneficiary_infos/createNewBeneficiaryNormal', 'Api\BeneficiaryInfoController@createNewBeneficiaryNormal');
        Route::post('beneficiary_infos/createNewBeneficiaryFast', 'Api\BeneficiaryInfoController@createNewBeneficiaryFast');
        Route::apiResource('beneficiary_infos', 'Api\BeneficiaryInfoController')->except(['update', 'index']);
        Route::post('beneficiary_infos', 'Api\BeneficiaryInfoController@index');
        Route::post('beneficiary_infos/{beneficiary_info}', 'Api\BeneficiaryInfoController@update');

        //sentences routes
        Route::apiResource('sentences', 'Api\SentenceController')->except('update');
        Route::post('sentences/{sentence}', 'Api\SentenceController@update');

        //languages routes
        Route::apiResource('languages', 'Api\LanguageController')->except('update');
        Route::post('languages/{language}', 'Api\LanguageController@update');

        //points routes
        Route::apiResource('points', 'Api\PointController')->except('update');
        Route::post('points/{point}', 'Api\PointController@update');
        
        //special needs types routes
        Route::apiResource('special_need_types', 'Api\SpecialNeedTypeController')->except('update');
        Route::post('special_need_types/{special_need_type}', 'Api\SpecialNeedTypeController@update');

        //phone_types routes
        Route::apiResource('phone_types', 'Api\PhoneTypeController')->except('update');
        Route::post('phone_types/{phone_type}', 'Api\PhoneTypeController@update');

        //location_types routes
        Route::apiResource('location_types', 'Api\LocationTypeController')->except('update');
        Route::post('location_types/{location_type}', 'Api\LocationTypeController@update');
        
        //ActivityWorkflowStepController
        Route::post('activities/processingRequest', 'Api\ActivityWorkflowStepController@processingRequest');
        Route::post('activities/assignStep', 'Api\ActivityWorkflowStepController@store');
        Route::post('activities/updateWorkflowStep/{activityWorkflowStep}', 'Api\ActivityWorkflowStepController@update');

        //activities routes
        Route::apiResource('activities', 'Api\ActivityController')->except('update');
        Route::post('activities/{activity}', 'Api\ActivityController@update');

        //steps routes
        Route::apiResource('steps', 'Api\StepController')->except('update');
        Route::post('steps/{step}', 'Api\StepController@update');

        //step approval routes
        // Route::post('step_approvals/processingRequest', 'Api\StepApprovalController@processingRequest');
        // Route::apiResource('step_approvals', 'Api\StepApprovalController')->except('update');
        // Route::post('step_approvals/{step_approval}', 'Api\StepApprovalController@update');

        //careers routes
        Route::apiResource('careers', 'Api\CareerController')->except('update');
        Route::post('careers/{career}', 'Api\CareerController@update');

        //polling stations routes
        Route::apiResource('polling_stations', 'Api\PollingStationController')->except('update');
        Route::post('polling_stations/{polling_station}', 'Api\PollingStationController@update');

        //locations routes
        Route::apiResource('locations', 'Api\LocationController')->except('update');
        Route::post('locations/{location}', 'Api\LocationController@update');
        
        //relations routes
        Route::apiResource('relations', 'Api\RelationController')->except('update');
        Route::post('relations/{relation}', 'Api\RelationController@update');

        //logs routes
        Route::prefix('events')->group(function () {
            
            Route::get('/', 'Api\EventController@showAll');
            Route::get('show-by-id/{id}', 'Api\EventController@showById');
            Route::post('show-by-action', 'Api\EventController@showByAction');
            Route::get('show-user-events/{id}', 'Api\EventController@showUserEvents');
            Route::get('show-last-week-event', 'Api\EventController@showLastWeekEvent');
            Route::get('show-last-month-event', 'Api\EventController@showLastMonthEvent');
            Route::get('show-last-day-event', 'Api\EventController@showLastDayEvent');
            Route::post('show-between-dates-event', 'Api\EventController@showBetweenDaysEvent');
            Route::post('show-all-model-events', 'Api\EventController@showAllModelEvents');
            Route::delete('delete/{id}', 'Api\EventController@delete');
        });

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
