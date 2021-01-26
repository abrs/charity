<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Message, Tenant};
use Illuminate\Http\Request;
use App\Models\Party_Info;
use App\Models\Type_Info;
use App\Rules\ValidModel;
use App\User;

class PartyInfoController extends Controller
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
                Party_Info::paginate(25)
            );
        });
    }

    /**
     * Store a newly created resource in storage.
     * the created party may or may not assigned to a type info directly
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'type_infos_id'=>['required', 'unique:party_infos,type_infos_id', new ValidModel('App\Models\Type_Info')],

            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $partyInfo = Party_Info::firstOrCreate(

                ['type_infos_id' => $request->type_infos_id],

                [
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 0,
                    'created_by' => auth()->user()->user_name,
                    'code' => $this->getCode(5, now()),
                ]
            );

           return Message::response(true, 'created', $partyInfo);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Party_Info  $party_info
     * @return \Illuminate\Http\Response
     */
    public function show(Party_Info $party_info)
    {
        return Tenant::wrapTenant(function() use ($party_info){

            return Message::response('true', 'done', $party_info);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Party_Info $party_info)
    {
        $validator = \Validator::make($request->all(), [
            'type_infos_id'=> [new ValidModel('App\Models\Type_Info') , 'required', 'unique:party_infos,type_infos_id,' . $party_info->id] ,

            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request, $party_info){

            $party_info->update(

                [
                    'type_infos_id' => $request->type_infos_id,
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 0,
                    'modified_by' => auth()->user()->user_name,
                ]
            );

           return Message::response(true, 'updated', Party_Info::findOrFail($party_info->id));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Party_Info $party_info
     * @return \Illuminate\Http\Response
     */
    public function destroy(Party_Info $party_info)
    {
        return Tenant::wrapTenant(function() use ($party_info){

            $party_info->delete();
            return Message::response(true, 'deleted');
        });
    }

    /**
     * get a unique code
     */
    private function getCode(int $length, string $prefix = null) { 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
      
        for ($i = 0; $i < $length; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
      
        return $prefix . $randomString; 
    }


    /**
     * add new party memeber
     * @param \Illuminate\Http\Request $request
     * @return \App\Helpers\Message
     */
    public function createNewParty(Request $request) {
        #1 get the party_info or build it
        $validator = \Validator::make($request->all(), [            

            #create new user
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password', 

            'name' => 'required', 
            'user_name' => 'required|unique:users',

            #create party
            'is_enabled' => 'nullable|boolean',
            // 'user_id' => ['required', new ValidModel('App\User')],
            'type_id' => ['required', new ValidModel('App\Models\Type')],
        ]);

        if($validator->fails()){
            
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }
        
        #2 assign it a type_infos
        // $typeInfo = Type_Info::where('user_id', $request->user_id)
        //     ->where('type_id', $request->type_id)
        //     ->first();

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
                
                #create a party details
                $partyInfo = Party_Info::firstOrCreate(

                    ['type_infos_id' => $typeInfo->id,],

                    [
                        'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 0,
                        'created_by' => auth()->user()->user_name,
                        'code' => $this->getCode(5, now()),
                    ]
                );

                return Message::response(true, 'created', $partyInfo);
            });
        });
    }
}
