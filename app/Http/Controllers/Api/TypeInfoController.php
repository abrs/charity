<?php

namespace App\Http\Controllers\Api;

use App\Models\Type_Info;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use App\Rules\ValidModel;

class TypeInfoController extends Controller
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
                Type_Info::with('party_info')->paginate(25)
            );
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, bool $fastSignup = false)
    {
        $validator = \Validator::make($request->all(), [

            'is_enabled' => 'nullable|boolean',
            'user_id' => ['required', 'numeric', new ValidModel('App\User')],
            'type_id' => ['required', 'numeric', new ValidModel('App\Models\Type')],
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        $typeInfo = Type_Info::checkOrcreate(
            ['user_id' => $request->user_id, 'type_id' => $request->type_id],
            [
                #if is_enabled is null then it's false
                'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                'created_by' => auth()->user()->user_name,
            ]
        );

        return $fastSignup ? $typeInfo :
            Message::response(true, 'created', $typeInfo);          
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type_Info  $type_Info
     * @return \Illuminate\Http\Response
     */
    public function show(Type_Info $type_info)
    {
        return Tenant::wrapTenant(function() use ($type_info){

            return Message::response('true', 'done', $type_info);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type_Info  $type_Info
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type_Info $type_info)
    {
        $validator = \Validator::make($request->all(), [

            'is_enabled' => 'nullable|boolean',
            'user_id' => ['required', 'numeric', new ValidModel('App\User')],
            'type_id' => ['required', 'numeric', new ValidModel('App\Models\Type')],
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }


        $type_info = $type_info->firstOrUpdate(
            [
                'user_id' => $request->user_id, 
                'type_id' => $request->type_id,
            ],

            [
                #if is_enabled is null then it's false
                'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                'modified_by' => auth()->user()->user_name,
            ]
        );

        return Message::response(true, 'updated', $type_info);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type_Info  $type_Info
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type_Info $type_info)
    {
        return Tenant::wrapTenant(function() use ($type_info){

            $type_info->delete();
            return Message::response(true, 'deleted');
        });
    }
}
