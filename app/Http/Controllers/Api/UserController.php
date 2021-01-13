<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\{Tenant, Message};
use App\User;

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

            'deleted_at' => 'nullable|date',
            'is_enabled' => 'nullable|boolean',
            'created_by' => 'required|alpha_num',
            'modified_by' => 'nullable|alpha_num',
        ]);

        if ($validator->fails()) {
            return Message::response(false,'Invalid Input' ,$validator->errors());
        }

        $password = bcrypt($request->password);

        $result = tenant()->run(function () use ($request, $password){

            try {
                $created_user = User::firstOrCreate(
                    #a user with the same name is an old user.
                    ['user_name' => $request->user_name],

                    [
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => $password,
                        'is_enabled' => $request->is_enabled,
                        'created_by' => $request->created_by,
                        // 'modified_by' => $request->modified_by,
                    ],
                );

                return Message::response(true, 'user created successfully', $created_user);

            } catch (\Exception $e) {
                return Message::response(false,'Invalid Input' ,$e->getMessage());
            }
        });

        return $result;
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
        $result = tenant()->run(function () use ($request){

            $request->user()->token()->revoke();
            return Message::response(true, 'user logged out successfully');
        });

        return $result;
    }
}
