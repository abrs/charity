<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
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
                Status::paginate(25)
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
            'name_en'=>['required', 'unique:statuses,name->en'],
            'name_ar'=>['required', 'unique:statuses,name->ar'],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $status = Status::firstOrcreate(                
                [
                    #if is_enabled is null then it's false
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'name' => [
                        'ar' => $request->name_ar,
                        'en' => $request->name_en,
                    ],
                    'created_by' => auth()->user()->user_name,
                ]
            );

            return Message::response(true, 'created', $status);          
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        return Tenant::wrapTenant(function() use ($status){

            return Message::response('true', 'done', $status);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        $validator = \Validator::make($request->all(), [
            'name_en'=>['required', 'unique:statuses,name->en,' . $status->id],
            'name_ar'=>['required', 'unique:statuses,name->ar,' . $status->id],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }
        
        return Tenant::wrapTenant(function() use ($status, $request){

            $status->update(
                [
                    'name' => [
                        'en' => $request->name_en,
                        'ar' => $request->name_ar,
                    ],
                    #if is_enabled is null then it's false
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    // 'created_by' => $request->created_by,
                    'modified_by' => auth()->user()->user_name,
                ]
            );

            return Message::response(true, 'updated', Status::findOrFail($status->id));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Status $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        return Tenant::wrapTenant(function() use ($status){

            $status->delete();
            return Message::response(true, 'deleted');
        });
    }
}
