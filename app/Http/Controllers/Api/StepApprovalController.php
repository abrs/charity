<?php

namespace App\Http\Controllers\Api;

use App\Models\StepApproval;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use App\Rules\ValidModel;
use Illuminate\Validation\Rule;

class StepApprovalController extends Controller
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
                StepApproval::paginate(25)
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
            'activity_workflow_steps_id'=>['required', new ValidModel('App\Models\ActivityWorkflowSteps')],
            'user_id'=>['required', new ValidModel('App\User')],
            'owner_id'=>['required', new ValidModel('App\User'), Rule::notIn($request->user_id)],
            'status_id'=>['required', new ValidModel('App\Models\Status')],

            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $stepApproval = StepApproval::firstOrCreate(

                [
                    'activity_workflow_steps_id' => $request->activity_workflow_steps_id,
                    'user_id' => $request->user_id,
                    'owner_id' => $request->owner_id,
                    'status_id' => $request->status_id,
                ],

                [
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'created_by' => auth()->user()->user_name,
                ]
            );

           return Message::response(true, 'created', $stepApproval);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StepApproval  $step_approval
     * @return \Illuminate\Http\Response
     */
    public function show(StepApproval $step_approval)
    {
        return Tenant::wrapTenant(function() use ($step_approval){

            return Message::response('true', 'done', $step_approval);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StepApproval  $step_approval
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StepApproval $step_approval)
    {
        $validator = \Validator::make($request->all(), [
            'activity_workflow_steps_id'=>['required', new ValidModel('App\Models\ActivityWorkflowSteps')],
            'user_id'=>['required', new ValidModel('App\User')],
            'owner_id'=>['required', new ValidModel('App\User'), Rule::notIn($request->user_id)],
            'status_id'=>['required', new ValidModel('App\Models\Status')],

            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request, $step_approval){

            $step_approval->update(

                [
                    'activity_workflow_steps_id' => $request->activity_workflow_steps_id,
                    'user_id' => $request->user_id,
                    'owner_id' => $request->owner_id,
                    'status_id' => $request->status_id,
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'modified_by' => auth()->user()->user_name,
                ]
            );

           return Message::response(true, 'updated', StepApproval::findOrFail($step_approval));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StepApproval  $step_approval
     * @return \Illuminate\Http\Response
     */
    public function destroy(StepApproval $step_approval)
    {
        return Tenant::wrapTenant(function() use ($step_approval){

            $step_approval->delete();
            return Message::response(true, 'deleted');
        });
    }
}