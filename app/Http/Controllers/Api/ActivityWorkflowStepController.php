<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Models\Activitable;
use App\Models\ActivityWorkflowSteps;
use App\Models\Beneficiary_Info;
use App\Models\BeneficiaryType;
use App\Models\Role;
use App\Models\Status;
use App\Models\StepApproval;
use App\Rules\ValidModel;
use Illuminate\Http\Request;

class ActivityWorkflowStepController extends Controller
{

    #store new activity workflow step..
    public function store(Request $request, bool $indirecRequest = false) {

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

        #there might be notifications here => use transactions
        return \DB::transaction(function () use ($request, $indirecRequest){
            
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

                    'description' => $request->description,
                    'status_id' => $request->status_id,

                    'created_by' => auth()->user()->user_name,
                ]
            );                
            //TODO: you may send notification to the beneficiary tells him about the new step here.


            return !$indirecRequest ? Message::response(true, 'activity assigned step successfully.', $activityWorkflowStep) :
                Null;
        });
    }    

    #----------  ---------   ---------   ----------    ----------  ---------   ---------   ----------

    #process beneficiary request
    public function processingRequest(Request $request) {

        $validator = \Validator::make($request->all(), [

            'status_id'=>['required', new ValidModel('App\Models\Status')],
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        //1- get the beneficiary locations
        $beneficiaryId = \DB::table('activity_workflow_steps')
            ->join('activitable', 'activity_workflow_steps.activitable_id', '=', 'activitable.id')
            ->distinct()->where('activitable.activitable_type', 'App\Models\Beneficiary_Info')
            ->value('activitable.activitable_id');

        //2- get the authenticated user locations
        $beneficiaryLocationsIds = Beneficiary_Info::findOrFail($beneficiaryId)->getUser()->locations->pluck('id')->all();

        //3- interscet the result (take in case if the admin is custodian(locations) or manager(point))
        $IntersectWithAuthUserLocations = \Auth::user()->locations()
            ->whereIn('locations.id', $beneficiaryLocationsIds)->get();
            
        //4- if there is common locations with the loggedIN user continue in the process else => don't continue in the process
        if($IntersectWithAuthUserLocations->isEmpty()) {
            
            return Message::response(true, 'there\'s no new beneficiaries within loggedIn user\'s locations');
        }

        //5- get only ActivityWorkflowSteps assigned to my roles
        $queryBelongsToMyRolesQuery = \DB::table('activity_workflow_steps')
            ->whereIn('step_supervisor_id', \Auth::user()->roles->pluck('id')->all());

        #if there were waiting steps and you are asking for pending ones then show the next waiting one instead of showing the next pended
        $waitingStatusId = Status::where('name', 'waiting')->first()->id;
        $pendingStatusId = Status::where('name', 'pending')->first()->id;
        $waitingRequest = ActivityWorkflowSteps::where('status_id', $waitingStatusId)->first();
        //TODO: when asking for waiting requests get the pended -but not the related to the waited -too.
        if($request->status_id == $pendingStatusId && $waitingRequest) {$request->status_id = $waitingRequest->id;}

        //get all the ActivityWorkflowSteps that have the status_id I choose
        $queryBelongsToMyRolesQuery->where('status_id', $request->status_id);
        //filter them to the ones have the minimum order_num
        $activityWorkflowStep = $queryBelongsToMyRolesQuery
            ->where('order_num', $queryBelongsToMyRolesQuery->min('order_num'))->get();


        $activityWorkflowStepResult = $activityWorkflowStep->map(function ($activityStep, $key){

            return ActivityWorkflowSteps::find($activityStep->id)->load([

                'activitable' => function ($query) use ($activityStep){
                    $query->where('id', $activityStep->activitable_id);
                },
                
                'step' => function ($query) use ($activityStep){
                    $query->where('id', $activityStep->step_id);
                },
    
                'status' => function ($query) use ($activityStep){
                    $query->where('id', $activityStep->status_id);
                },
            ]);
        });

        return Message::response(true, 'done', $activityWorkflowStepResult);
    }

    #-------    ----------  ---------   ---------   ----------    ----------  ---------   ---------   ----------

    #update an activity workflow step
    public function update(Request $request, ActivityWorkflowSteps $activityWorkflowStep) {

        $validator = \Validator::make($request->only('status_id', 'description'), [

            'status_id' => ['required', new ValidModel('App\Models\Status')],
            'description' => ['required', 'min:10'],
            /*TODO: let me update the type of the beneficiary to accepted, rejected or let it as it is
                in this phase -just change its status_id- till the next one, I'll make it in another api.
            */
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        #there might be notifications here => use transactions
        return \DB::transaction(function () use ($request, $activityWorkflowStep){
            
            #1- update the workflow step status and add a useful description
            $activityWorkflowStep->update(
                [
                    'description' => $request->description,
                    'status_id' => $request->status_id,

                    'modified_by' => auth()->user()->user_name,
                ]
            );

            #2- processing custodian has no special accessories, but manger acceptance has
            $custodian = Role::where(['name' => 'custodian', 'id' => $activityWorkflowStep->step_supervisor_id])->first();
            $manager = Role::where(['name' => 'manager', 'id' => $activityWorkflowStep->step_supervisor_id])->first();

            if($custodian) {
                #rejection scenario
                if($request->status_id == Status::where('name', 'cancelled')->first()->id) {
                    //TODO: I reached here.
                }
            }

            if($manager) {
                #acceptance scenario
                if($request->status_id == Status::where('name', 'approved')->first()->id) {
                    #change the beneficiary type to accepted.
                    $activitable = Activitable::find($activityWorkflowStep->activitable_id);
                    #only works if it related to beneficiary processing
                    $beneficiaryId = $activitable->activitable_id;
                    $beneficiary = Beneficiary_Info::find($beneficiaryId);

                    $acceptedBeneficiaryType = BeneficiaryType::where('name', 'accepted')->first();
                    if(!$acceptedBeneficiaryType) {return Message::response(true, 'create the beneficiary type \"accepted\" first!!');}

                    #change the type of the beneficiry to accepted if the manager gave him his approval.
                    $beneficiary->beneficiary_type()->associate($acceptedBeneficiaryType->id);
                    $beneficiary->save();
                }
            }

            //TODO: you may send notification to the beneficiary tells him about the new step here.

            return Message::response(true, 'activity step updated successfully..');
        });
    }
}
