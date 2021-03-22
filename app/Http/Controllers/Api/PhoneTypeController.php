<?php

namespace App\Http\Controllers\Api;

use App\Models\PhoneType;
use Illuminate\Http\Request;
use App\Helpers\{Tenant, Message};
use App\Http\Controllers\Controller;

class PhoneTypeController extends Controller
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
                PhoneType::paginate(25)
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
            // 'name_en'=>['required', 'unique:phone_types,name->en'],
            'name'=>['required', 'unique:phone_types,name'],
            'is_enabled' => 'nullable|boolean',
            // 'deleted_at' => 'nullable|date',
            // 'created_by' => 'nullable|alpha_num',
            // 'modified_by' => 'nullable|alpha_num',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $phoneType = PhoneType::firstOrcreate(
                [
                    #if is_enabled is null then it's false
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'name' => $request->name,
                        // 'en' => $request->name_en,
                    // ],
                    // 'name' => $request->name,
                    'created_by' => auth()->user()->user_name,                     
                ]
            );

            return Message::response(true, 'created', $phoneType);          
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PhoneType  $phoneType
     * @return \Illuminate\Http\Response
     */
    public function show(PhoneType $phoneType)
    {
        return Tenant::wrapTenant(function() use ($phoneType){

            return Message::response('true', 'done', $phoneType);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PhoneType  $phoneType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PhoneType $phoneType)
    {
        $validator = \Validator::make($request->all(), [
            // 'name_en'=>['required', 'unique:phone_types,name->en,' . $phoneType->id],
            'name'=>['required', 'unique:phone_types,name,' . $phoneType->id],
            // 'deleted_at' => 'nullable|date',
            'is_enabled' => 'nullable|boolean',
            // 'created_by' => 'nullable|alpha_num',
            // 'modified_by' => 'required|alpha_num',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }
        
        return Tenant::wrapTenant(function() use ($phoneType, $request){

            $phoneType->update(
                [
                    'name' => $request->name,
                        // 'en' => $request->name_en,
                    // ],
                    // 'name' => $request->name,
                    #if is_enabled is null then it's false
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    // 'created_by' => $request->created_by,
                    'modified_by' => auth()->user()->user_name,
                ]
            );

            return Message::response(true, 'updated', phoneType::findOrFail($phoneType->id));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PhoneType  $phoneType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhoneType $phoneType)
    {
        return Tenant::wrapTenant(function() use ($phoneType){

            $phoneType->delete();
            return Message::response(true, 'deleted');
        });
    }
}
