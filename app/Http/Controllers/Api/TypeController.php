<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use Illuminate\Http\Request;
use App\Models\Type;

class TypeController extends Controller
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
                Type::with('users')->paginate(25)
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
            // 'name_en'=>['required', 'unique:types,name->en'],
            'name'=>['required', 'unique:types,name'],
            // 'deleted_at' => 'nullable|date',
            'is_enabled' => 'nullable|boolean',
            // 'created_by' => 'nullable|alpha_num',
            // 'modified_by' => 'nullable|alpha_num',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        $type = Type::checkOrcreate(
            [
                'name' => $request->name,
            ],
            [
                #if is_enabled is null then it's false
                'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                //     'en' => $request->name_en,
                // ],
                'created_by' => auth()->user()->user_name,
            ]
        );

        return Message::response(true, 'created', $type);          
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        return Tenant::wrapTenant(function() use ($type){

            return Message::response('true', 'done', $type);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        $validator = \Validator::make($request->all(), [
            'name'=>['required', 'unique:types,name,' . $type->id],
            // 'name_ar'=>['required', 'unique:types,name->ar,' . $type->id],
            // 'deleted_at' => 'nullable|date',
            'is_enabled' => 'nullable|boolean',
            // 'created_by' => 'nullable|alpha_num',
            // 'modified_by' => 'required|alpha_num',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }
        
        return Tenant::wrapTenant(function() use ($type, $request){

            $type->update(
                [
                    'name' => $request->name,
                    //     'ar' => $request->name_ar,
                    // ],
                    #if is_enabled is null then it's false
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    // 'created_by' => $request->created_by,
                    'modified_by' => auth()->user()->user_name,
                ]
            );

            return Message::response(true, 'updated', Type::findOrFail($type->id));
        });

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        return Tenant::wrapTenant(function() use ($type){

            $type->delete();
            return Message::response(true, 'deleted');
        });
    }
}
