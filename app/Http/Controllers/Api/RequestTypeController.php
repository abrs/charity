<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use Illuminate\Http\Request;
use App\Models\RequestType;
use App\Rules\ValidModel;

class RequestTypeController extends Controller
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
                RequestType::paginate(25)
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
            'kind_id'=>['required', new ValidModel('App\Models\Kind')],
            'name'=>['required', 'unique:request_types,name'],
            'max_days' => ['nullable', 'integer'],
            'max_hours' => ['nullable', 'integer'],
            'note' => ['nullable'],

            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $requestType = RequestType::firstOrCreate(

                ['name' => $request->name],

                [
                    'kind_id' => $request->kind_id,

                    'is_enabled'=> $request->has('is_enabled') ? $request->is_enabled : 1,
                    'max_days'  => $request->has('max_days') ? $request->max_days : Null,
                    'max_hours' => $request->has('max_hours') ? $request->max_hours : Null,
                    'note'      => $request->has('note') ? $request->note : Null,

                    'created_by'=> auth()->user()->user_name,
                ]
            );

           return Message::response(true, 'created', $requestType);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequestType  $request_type
     * @return \Illuminate\Http\Response
     */
    public function show(RequestType $request_type)
    {
        return Tenant::wrapTenant(function() use ($request_type){

            return Message::response('true', 'done', $request_type);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestType  $request_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestType $request_type)
    {
        $validator = \Validator::make($request->all(), [
            'kind_id'=>['nullable', new ValidModel('App\Models\Kind')],
            'name'=>['nullable', 'unique:request_types,name,' . $request_type->id],
            'max_days' => ['nullable', 'integer'],
            'max_hours' => ['nullable', 'integer'],
            'note' => ['nullable'],

            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request, $request_type){

            $request_type->update(

                [
                    'name' => $request->name,
                    'kind_id' => $request->kind_id,

                    'is_enabled'=> $request->has('is_enabled') ? $request->is_enabled : 1,
                    'max_days'  => $request->max_days,
                    'max_hours' => $request->max_hours,
                    'note'      => $request->note,

                    'modified_by' => auth()->user()->user_name,
                ]
            );

           return Message::response(true, 'updated', RequestType::findOrFail($request_type));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestType  $request_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestType $request_type)
    {
        return Tenant::wrapTenant(function() use ($request_type){

            $request_type->delete();
            return Message::response(true, 'deleted');
        });
    }
}
