<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\{Tenant, Message};
use App\Rules\ValidModel;
use App\User;
use App\Models\Role;

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

    public function signup(Request $request) 
    {
        $validator = \Validator::make($request->all(), [

            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password', 

            'name' => 'required', 
            'user_name' => 'required|unique:users',
        ]);

        if ($validator->fails()) {
            return Message::response(false,'Invalid Input' ,$validator->errors());
        }

        $password = bcrypt($request->password);

        return Tenant::wrapTenant(function() use ($request, $password){

            $created_user = User::firstOrCreate(
                #a user with the same name is an old user.
                ['user_name' => $request->user_name],

                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $password,
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    // 'created_by' => auth()->user()->user_name,
                ],
            );

            #after creating a user by default he is a normal user
            $created_user->assignRole('normal');

            return Message::response(true, 'user created successfully', $created_user);
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
                    $token->expires_at = Carbon::now()->addWeeks(1);
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
    
}
