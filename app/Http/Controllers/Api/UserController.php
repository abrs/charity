<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\{Tenant, Message};
use App\Models\Relation;
use App\Rules\ValidModel;
use App\User;
use App\Models\Role;
use App\Models\Type;
use App\Models\UserRelation;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller
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
                User::paginate(25)
            );
        });
    }

    public function signup(Request $request, bool $fastSignup = false) 
    {     
        $validator = \Validator::make($request->all(), [

            'password' => 'required',
            'email' => ['required', 'email'],
            'confirm_password' => 'required|same:password', 
            'user_name' => 'required|unique:users',

        ]);

        if ($validator->fails()) {

            // return $fastSignup ? $validator->errors() : 
            return Message::response(false,'Invalid Input' ,$validator->errors());
        }

        $password = bcrypt($request->password);

        return Tenant::wrapTenant(function() use ($request, $password, $fastSignup){

            $created_user = User::firstOrCreate(
                #a user with the same name is an old user.
                ['user_name' => $request->user_name],

                [
                    'password' => $password,
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                ],
            );

            #after creating a user by default he is a normal user
            $created_user->assignRole('normal');

            return $fastSignup ? $created_user : 
                Message::response(true, 'user created successfully', $created_user);
        });
    }

    #--------- ---------- -------------- ------------ ---------------

    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [

            'user_name' => 'required',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        if ($validator->fails()) {
            return Message::response(false,'Invalid Input' ,$validator->errors());
        }

        $credentials = request(['user_name', 'password']);

        $result = tenant()->run(function () use ($credentials, $request){

            if(!Auth::attempt($credentials)) {
    
                return Message::response(false,'Authorization failed');  
            }

            try {
                $user = $request->user();
                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->token;
        
                if ($request->remember_me) {
                    #when a remember_me with true sent, extend the user token's life a week
                    $token->expires_at = Carbon::now()->addMonth();
                }else {
                    $token->expires_at = Carbon::now()->addWeek();
                }
        
                $token->save();
            } catch (\Exception $e) {
                return Message::response(false,'Invalid request' ,$e->getMessage());
            }
    
            
            return Message::response(true, 'Authorization Granted', [

                'user' => $user,
                
                'Auth-details' => [
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString()
                ],
            ]);
        });
        
        return $result;
    }

    #----------------------------------------------------
    //get the user profile
    public function getProfile() {

        // return Tenant::wrapTenant(function() {

            return Message::response(true, 'done' ,User::find(\Auth::user()->id)
                ->load(['types', 'roles.permissions', 'relations', 'phones', 'locations'])
                ->loadMissing(['type_infos' => function ($query) {
                    $query->has('beneficiary_info');
                }])
                // ->load('type_infos')->has('type_infos.beneficiary_info')
            );
        // });
    }

    #----------------------------------------------------

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        // $result = tenant()->run(function () use ($request){

        $request->user()->token()->revoke();
        return Message::response(true, 'user logged out successfully');
        // });

        // return $result;
    }

    #========================================
    #   User's roles and permissions    =====
    #==========================================

    /** 
     * assign user a role
    */
    public function assignRoleToUser(Request $request) {

        $validator = \Validator::make($request->all(), [

            'user_id' => ['required', new ValidModel('App\User')],
            'role_id' => ['required', new ValidModel('App\Models\Role')],
        ]);

        if ($validator->fails()) {
            return Message::response(false,'Invalid Input' ,$validator->errors());
        }

        return Tenant::wrapTenant(function() use ($request) {

            \DB::table('model_has_roles')->insert([
                'role_id' => $request->role_id,
                'model_type' => User::class,
                'model_id' => $request->user_id,
            ]);
                
            return Message::response(true,'assigned successfully');
        });
    }

    #assign user a type
    public function assignType(Request $request, bool $fastSignup = false) {

        $validator = \Validator::make($request->all(), [

            'type_id' => ['required', new ValidModel('App\Models\Type')],
            'user_id' => ['required', new ValidModel('App\User')],
        ]);

        if ($validator->fails()) {
            return Message::response(false,'Invalid Input' ,$validator->errors());
        }

        return Tenant::wrapTenant(function() use ($request, $fastSignup) {

            $type = Type::find($request->type_id);
            $user = User::find($request->user_id);
            
            if(! $user->types->contains($type)) {

                $user->types()->save($type, [            
                    'created_by' => auth()->user()->user_name,                    
                ]);
            }

            return $fastSignup ? $type :
                Message::response(true, 'assigned', $type);
        });
    }

        /**
     * ===============================================================
     * ===================== extra functionality =====================
     * ==================================================
     */

     
    /**
     * assign user a phone
     * @param \Illuminate\Http\Request $request
     * @return \App\Helpers\Message
     */
    public function assignUserPhone(Request $request) {

        $validator = \Validator::make($request->all(), [
            'is_enabled'        => ['nullable', 'boolean'],

            'user_id'    => ['required', new ValidModel('App\User')],
            'phone_type_id'  => ['required', new ValidModel('App\Models\PhoneType')],
            'number'       => ['required', 'unique:phones,number'],
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){
                    
            \DB::table('phones')->insert(
                [
                    'user_id' => $request->user_id,
                    'phone_type_id' => $request->phone_type_id,
                    'number' => $request->number,
                
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'created_by' => auth()->user()->user_name,

                    'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                ]
            );

            $phone = \DB::table('phones')->where('number', $request->number)->first();
            
            return Message::response(true, 'attached successfully', $phone);
        });
    }

    /**
     * assign user a location
     * @param \Illuminate\Http\Request $request
     * @return \App\Helpers\Message
     */
    public function assignUserLocation(Request $request) {

        $validator = \Validator::make($request->all(), [
            'is_enabled'        => ['nullable', 'boolean'],

            'user_id'    => ['required', new ValidModel('App\User')],
            'location_type_id'  => ['required', new ValidModel('App\Models\LocationType')],
            'location_id'       => ['required', new ValidModel('App\Models\Location')],
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $userLocation = \DB::table('user_location')
                ->where('user_id', $request->user_id)
                ->where('location_type_id', $request->location_type_id)
                ->where('location_id', $request->location_id)
                ->first();

            if(!$userLocation) {

                \DB::table('user_location')->insert(
                    [
                        'user_id' => $request->user_id,
                        'location_type_id' => $request->location_type_id,
                        'location_id' => $request->location_id,
                    
                        'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                        'created_by' => auth()->user()->user_name,

                        'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                    ]
                );
                
                $userLocation = \DB::table('user_location')
                ->where('user_id', $request->user_id)
                ->where('location_type_id', $request->location_type_id)
                ->where('location_id', $request->location_id)
                ->first();
            }


           return Message::response(true, 'attached successfully', $userLocation);
        });
    }


    /**
     * assign user a relation
     * @param \Illuminate\Http\Request $request
     * @return \App\Helpers\Message
     */
    public function assignUserRelation(Request $request) {

        $validator = \Validator::make($request->all(), [
            'is_enabled'        => ['nullable', 'boolean'],

            'user_id'    => ['required', new ValidModel('App\User')],
            's_user_id'  => ['nullable', new ValidModel('App\User'), Rule::notIn($request->user_id)],
            'relation_id'       => ['required', new ValidModel('App\Models\Relation')],
            'family_budget'     => ['required_if:relation_id,' . Relation::where('name', "Breadwinner")->first()->id],
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            UserRelation::firstOrCreate(
                [
                    'user_id' => $request->user_id,
                    'relation_id' => $request->relation_id,
                    's_user_id' => $request->s_user_id,
                ],
                [
                    'family_budget' => $request->has('family_budget') ? $request->family_budget : NULL,
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'created_by' => auth()->user()->user_name,
                ]
            );

           return Message::response(true, 'attached successfully');
        });
    }

    /**
     * unassign user a relation
     * @param \Illuminate\Http\Request $request
     * @return \App\Helpers\Message
     */
    public function unAssignUserRelation(Request $request) {

        $validator = \Validator::make($request->all(), [

            'user_id' => ['required', new ValidModel('App\User')],
            'relation_id'    => ['required', new ValidModel('App\Models\Relation')],
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $user = User::find($request->user_id);

            $user->relations()->detach($request->relation_id);

           return Message::response(true, 'unattached successfully');
        });
    }

    public function getAllUsersBelongsToType(Request $request) {

        $validator = \Validator::make($request->all(), [

            'type_id' => ['required', new ValidModel('App\Models\Type')],
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $beneficiaryUsers = User::whereHas('types', function(Builder $query) use ($request) {

                $query->where('type_id', $request->type_id);

            })->get();

           return Message::response(true, 'done', $beneficiaryUsers);
        });
    }

    public function getAllTheBeneficiariesUsers() {

        return Tenant::wrapTenant(function() {

            $beneficiaryType = Type::where('name', 'beneficiary')->first();

            if(!$beneficiaryType) {
                
                return Message::response(false, 'create beneficiary type first!!');
            }

            $beneficiaryUsers = User::whereHas('types', function(Builder $query) use ($beneficiaryType) {

                $query->where('type_id', $beneficiaryType->id);

            })->get();

           return Message::response(true, 'done', $beneficiaryUsers);
        });
    }
}
