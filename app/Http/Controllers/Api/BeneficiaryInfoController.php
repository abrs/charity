<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use App\Models\Activity;
use App\Models\ActivityBeneficiary;
use App\Models\Beneficiary_Info;
use App\Models\Type_Info;
use App\Rules\ValidModel;
use App\User;
use Illuminate\Http\Request;

class BeneficiaryInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return Tenant::wrapTenant(function() {
                        
            return Message::response(
                true,
                'done',
                Beneficiary_Info::paginate(25)
            );
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'type_infos_id'=>['required', 'unique:beneficiary_infos,type_infos_id', new ValidModel('App\Models\Type_Info')],
            'location_id'=>['required', new ValidModel('App\Models\Location')],

            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $beneficiaryInfo = Beneficiary_Info::firstOrCreate(

                ['type_infos_id' => $request->type_infos_id],

                [
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 0,
                    'location_id' => $request->location_id,
                    'created_by' => auth()->user()->user_name,
                ]
            );

           return Message::response(true, 'created', $beneficiaryInfo);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beneficiary_Info  $beneficiary_info
     * @return \Illuminate\Http\Response
     */
    public function show(Beneficiary_Info $beneficiary_info)
    {
        return Tenant::wrapTenant(function() use ($beneficiary_info){

            return Message::response('true', 'done', $beneficiary_info);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Beneficiary_Info  $beneficiary_info
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Beneficiary_Info $beneficiary_info)
    {
        $validator = \Validator::make($request->all(), [
            'type_infos_id'=>['required', new ValidModel('App\Models\Type_Info'), 'unique:beneficiary_infos,type_infos_id,' . $beneficiary_info->id],
            'location_id'=>['required', new ValidModel('App\Models\Location')],

            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request, $beneficiary_info){

            $beneficiary_info->update(

                [
                    'type_infos_id' => $request->type_infos_id,
                    'location_id' => $request->location_id,
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 0,
                    'modified_by' => auth()->user()->user_name,
                ]
            );

           return Message::response(true, 'updated', Beneficiary_Info::findOrFail($beneficiary_info->id));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Beneficiary_Info  $beneficiary_info
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beneficiary_Info $beneficiary_info)
    {
        return Tenant::wrapTenant(function() use ($beneficiary_info){

            $beneficiary_info->delete();
            return Message::response(true, 'deleted');
        });
    }

    /**
     * add new beneficiary memeber
     * @param \Illuminate\Http\Request $request
     * @return \App\Helpers\Message
     */
    public function createNewBeneficiary(Request $request) {
        
        $validator = \Validator::make($request->all(), [

            #create new user
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password', 

            'name' => 'required', 
            'user_name' => 'required|unique:users',

            #create beneficiary
            'location_id'=>['required', new ValidModel('App\Models\Location')],

            'is_enabled' => 'nullable|boolean',
            // 'user_id' => ['required', 'numeric', new ValidModel('App\User')],
            'type_id' => ['required', 'numeric', new ValidModel('App\Models\Type')],
        ]);

        if($validator->fails()){
            
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        #create a password for the user
        $password = bcrypt($request->password);

        return Tenant::wrapTenant(function() use ($request, $password){

            return \DB::transaction(function () use ($request, $password){

                #1- create user
                $created_user = User::firstOrCreate(
                    #a user with the same name is an old user.
                    ['user_name' => $request->user_name],

                    [
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => $password,
                        'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 0,
                        'created_by' => auth()->user()->user_name,
                    ],
                );

                #2- create a type info between a user and a created type.
                $typeInfo = Type_Info::firstOrcreate(
                    ['user_id' => $created_user->id, 'type_id' => $request->type_id],
                    [
                        #if is_enabled is null then it's false
                        'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 0,
                        'created_by' => auth()->user()->user_name,
                    ]
                );

                #create a beneficiary details
                $beneficiaryInfo = Beneficiary_Info::firstOrCreate(

                    ['type_infos_id' => $typeInfo->id],
                    [
                        'location_id' => $request->location_id,
                        'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 0,
                        'created_by' => auth()->user()->user_name,
                    ]
                );

                return Message::response(true, 'created', $beneficiaryInfo);

            });
        });
    }


    #attach a beneficiary an activity
    public function attachBeneficiaryAnActivity(Request $request) {

        $validator = \Validator::make($request->all(), [
            'is_enabled' => ['nullable', 'boolean'],
            'beneficiary_info_id'=>['required', new ValidModel('App\Models\Beneficiary_Info')],
            'activity_id'=>['required', new ValidModel('App\Models\Activity')],
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $activityBeneficiary = ActivityBeneficiary::firstOrCreate(
                [
                    'beneficiary_id'    => $request->beneficiary_info_id,
                    'activity_id'       => $request->activity_id,
                ],

                [                
                    'created_by' => auth()->user()->user_name,
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 0,
                ]
            );

           return Message::response(true, 'attached successfully', $activityBeneficiary);
        });
    }

    #detach a beneficiary an activity
    public function detachBeneficiaryAnActivity(Request $request) {

        $validator = \Validator::make($request->all(), [
            'beneficiary_info_id'=>['required', new ValidModel('App\Models\Beneficiary_Info')],
            'activity_id'=>['required', new ValidModel('App\Models\Activity')],
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $beneficiary_info = Beneficiary_Info::findOrFail($request->beneficiary_info_id);

            $beneficiary_info->activities()->detach($request->activity_id);

           return Message::response(true, 'detached successfully');
        });
    }
}
