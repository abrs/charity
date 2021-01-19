<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
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
                Activity::paginate(25)
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
            'name'=>['required', 'unique:activities,name'],

            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $activity = Activity::firstOrCreate(

                ['name' => $request->name],

                [
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 0,
                    'created_by' => auth()->user()->user_name,
                ]
            );

           return Message::response(true, 'created', $activity);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        return Tenant::wrapTenant(function() use ($activity){

            return Message::response('true', 'done', $activity);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        $validator = \Validator::make($request->all(), [
            'name'=>['required', 'unique:activities,name'],

            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request, $activity){

            $activity->update(

                [
                    'name' => $request->name,
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 0,
                    'modified_by' => auth()->user()->user_name,
                ]
            );

           return Message::response(true, 'updated', Activity::findOrFail($activity->id));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        return Tenant::wrapTenant(function() use ($activity){

            $activity->delete();
            return Message::response(true, 'deleted');
        });
    }
}
