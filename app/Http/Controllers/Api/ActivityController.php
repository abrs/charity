<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Step;
use App\Rules\ValidModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
            // 'name_en'=>['required', 'unique:activities,name->en'],
            'name'=>['required', 'unique:activities,name'],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

            $activity = Activity::checkOrCreate(
                [

                    'name' => $request->name,
                ],
                [
                    #if is_enabled is null then it's false
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                        // 'en' => $request->name_en,
                    // ],
                    'created_by' => auth()->user()->user_name,
                ]
            );

            return Message::response(true, 'created', $activity);          
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
            'name'=>['required', 'unique:activities,name,' . $activity->id],
            // 'name_ar'=>['required', 'unique:activities,name->ar,' . $activity->id],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }
        
        return Tenant::wrapTenant(function() use ($activity, $request){

            $activity->update(
                [
                    'name' => $request->name,
                        // 'ar' => $request->name_ar,
                    // ],
                    #if is_enabled is null then it's false
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    // 'created_by' => $request->created_by,
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

    /**
     * =============
     * extra functionality
     * -------
     */
    public function assignAndCreateNewStep(Request $request) {
        $validator = \Validator::make($request->all(), [
            #activity
            'activity_id'=> ['required', new ValidModel('App\Models\Activity')],
            #step
            // 'name_en'=>['required', 'unique:steps,name->en'],
            'name'=>['required', 'unique:steps,name'],
            // 'description_en'=>['nullable'],
            'description'=>['nullable'],
            'is_enabled' => 'nullable|boolean',
            #workflow_steps
            'order_num' => ['required', 'unique:activity_workflow_steps'],
            'finishing_percentage' => ['required'],
            'required' => ['required'],
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            return \DB::transaction(function () use ($request){

                $step = Step::create(
                    [                        
                        'name' => $request->name,
                            // 'en' => $request->name_en,
                        // ],
    
                        'description' => $request->has('description') ? $request->description : Null,
                            // 'en' => $request->has('description_en') ? $request->description_en : Null,
                        // ],
                        #if is_enabled is null then it's false
                        'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                        'created_by' => auth()->user()->user_name,
                    ]
                );
    
                $activity = Activity::find($request->activity_id);
                $activity->steps()->save($step, [
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'created_by' => auth()->user()->user_name,
                    'order_num' => $request->order_num,            
                    'finishing_percentage' => $request->finishing_percentage,            
                    'required' => $request->required,            
                ]);
    
                return Message::response(true, 'assigned', $activity->load('steps'));
            });
        });
    }

    
}
