<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use App\Models\SpecialNeedType;
use Illuminate\Http\Request;

class SpecialNeedTypeController extends Controller
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
                SpecialNeedType::all()
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
            // 'name_en'=>['required', 'unique:special_need_types,name->en'],
            'name'=>['required', 'unique:special_need_types,name'],            
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        $specialNeedType = SpecialNeedType::checkOrcreate(
            [
                'name' => $request->name,
            ],
            [
                #if is_enabled is null then it's false
                'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    // 'en' => $request->name_en,
                // ],
                // 'name' => $request->name,
                'created_by' => auth()->user()->user_name,                     
            ]
        );

        return Message::response(true, 'created', $specialNeedType);          
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SpecialNeedType  $specialNeedType
     * @return \Illuminate\Http\Response
     */
    public function show(SpecialNeedType $specialNeedType)
    {
        return Tenant::wrapTenant(function() use ($specialNeedType){

            return Message::response('true', 'done', $specialNeedType);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SpecialNeedType  $specialNeedType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SpecialNeedType $specialNeedType)
    {
        $validator = \Validator::make($request->all(), [
            'name'=>['required', 'unique:special_need_types,name,' . $specialNeedType->id],
            // 'name_en'=>['required', 'unique:special_need_types,name->en,' . $specialNeedType->id],
            // 'deleted_at' => 'nullable|date',
            'is_enabled' => 'nullable|boolean',
            // 'created_by' => 'nullable|alpha_num',
            // 'modified_by' => 'required|alpha_num',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }
        
        return Tenant::wrapTenant(function() use ($specialNeedType, $request){

            $specialNeedType->update(
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

            return Message::response(true, 'updated', SpecialNeedType::findOrFail($specialNeedType->id));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SpecialNeedType  $specialNeedType
     * @return \Illuminate\Http\Response
     */
    public function destroy(SpecialNeedType $specialNeedType)
    {
        return Tenant::wrapTenant(function() use ($specialNeedType){

            $specialNeedType->delete();
            return Message::response(true, 'deleted');
        });
    }
}
