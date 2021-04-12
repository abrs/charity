<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Models\Activitable;
use App\Models\ActivityWorkflowSteps;
use App\Models\Status;
use App\Models\StepApproval;
use App\Rules\ValidModel;
use Illuminate\Http\Request;

class ActivityWorkflowStepController extends Controller
{
    public function store(Request $request) {

        $validator = \Validator::make($request->all(), [
            #activity
            'activitable_id' => ['required', new ValidModel('App\Models\Activitable')],
            #step
            'step_id' => ['required', new ValidModel('App\Models\Step')],
            'step_supervisor_id' => ['required', new ValidModel('App\Models\Role')],            

            'order_num' => ['required', 'numeric', 'gte:0'],
            'finishing_percentage' => ['required', 'numeric', 'gte:0', 'lte:100'],
            'required' => ['required', 'boolean'],
            
            //to create a step_approval
            'status_id' => ['required', new ValidModel('App\Models\Status')],
            'description' => ['required', 'min:10'],
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return \DB::transaction(function () use ($request){
            
            $activityWorkflowStep = ActivityWorkflowSteps::firstOrCreate(
                [
                    'activitable_id' => $request->activitable_id,
                    'step_id' => $request->step_id,
                ],

                [
                    'step_supervisor_id' => $request->step_supervisor_id,
                    'order_num' => $request->order_num,
                    'finishing_percentage' => $request->finishing_percentage,
                    'required' => $request->required,
                    'created_by' => auth()->user()->user_name,
                ]
            );
                
            $oldStepApproval = StepApproval::where('activity_workflow_steps_id', $activityWorkflowStep->id)->first();

            if($oldStepApproval) {

                return Message::response(false, 'You\'ve assigned old activity and step');
            }

            //after the activity Workflow Step created successfully assign it to a step_approval with a choosen status and description
            $activityWorkflowStep->step_approval()->attach($request->status_id, [
                'description' => $request->description,
                'created_by' => auth()->user()->user_name,
            ]);
            //TODO: you may send notification to the beneficiary tells him about the new step here.


            return Message::response(true, 'activity assigned step successfully.', $activityWorkflowStep);
        });
    }    
}
