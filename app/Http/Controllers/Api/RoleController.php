<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Rules\ValidModel;

class RoleController extends Controller
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
                Role::paginate(25)
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
            'name'=>['required', 'unique:roles'],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $role = Role::create(
                [
                    'name' => $request->name,
                    #if is_enabled is null then it's false
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'created_by' => auth()->user()->user_name,
                ]
            );

            return Message::response(true, 'created', $role);          
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return Tenant::wrapTenant(function() use ($role){

            return Message::response('true', 'done', $role);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validator = \Validator::make($request->all(), [
            'name'=>['required', 'unique:roles,name, ' . $role->id],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($role, $request){

            $role->update(
                [
                    'name' => $request->name,
                    #if is_enabled is null then it's false
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'modified_by' => auth()->user()->user_name,
                ]
            );

            return Message::response(true, 'updated', Role::findOrFail($role->id));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        return Tenant::wrapTenant(function() use ($role){

            $role->delete();
            return Message::response(true, 'deleted');
        });
    }

    /**
     * add permission to role
     */
    public function addPermissionToRole(Request $request) {

        $validator = \Validator::make($request->all(), [
            'role_id'=> ['required', new ValidModel('App\Models\Role')],
            'permission_id' => ['required', new ValidModel('App\Models\Permission')],
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        
        return Tenant::wrapTenant(function() use ($request){
            
            $role = Role::find($request->role_id);
            $permission = Permission::find($request->permission_id);

            $role->givePermissionTo($permission);

            return Message::response(true, 'attached');
        });
    }

    /**
     * remove permission from a role
     */
    public function removePermissionFromRole(Request $request) {

        $validator = \Validator::make($request->all(), [
            'role_id'=> ['required', new ValidModel('App\Models\Role')],
            'permission_id' => ['required', new ValidModel('App\Models\Permission')],
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        
        return Tenant::wrapTenant(function() use ($request){
            
            $role = Role::find($request->role_id);
            $permission = Permission::find($request->permission_id);

            $role->revokePermissionTo($permission);

            return Message::response(true, 'detached');
        });
    }
    
}
