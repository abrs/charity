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
            
            $activityWorkflowStep = ActivityWorkflowSteps::checkOrCreate(
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
    public function processingRequest() {

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

        /*if there were waiting steps 
            then get me the waited activitable_id if there were any and the pended ones that are related to other activitable
        */
        $waitingStatusId = Status::where('name', 'waiting')->first()->id;
        $pendingStatusId = Status::where('name', 'pending')->first()->id;

        $waitingRequests = ActivityWorkflowSteps::where('status_id', $waitingStatusId)->get();

        if($waitingRequests->isNotEmpty()) {

            $waitingRequestActivitableId = $waitingRequests->pluck('activitable_id')->all();
    
            $pendingRequestId = ActivityWorkflowSteps::where('status_id', $pendingStatusId)
                ->whereNotIn('activitable_id', $waitingRequestActivitableId)->get('id');

            //get me the waited activitable_id if there were any and the pended ones that are related to other activitable
            $queryBelongsToMyRolesQuery->whereIn('id', $waitingRequests->pluck('id')->merge($pendingRequestId)->all());

        }else {

            //get all the ActivityWorkflowSteps that have the status_id pended
            $queryBelongsToMyRolesQuery->where('status_id', $pendingStatusId);
        }

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
            $activityWorkflowStep->firstOrUpdate(
                [
                    'status_id' => $request->status_id,
                ],

                [
                    'description' => $request->description,

                    'modified_by' => auth()->user()->user_name,
                ]
            );

            #2- processing custodian has no special accessories, but manger acceptance has
            $custodian = Role::where(['name' => 'custodian', 'id' => $activityWorkflowStep->step_supervisor_id])->first();
            $manager = Role::where(['name' => 'manager', 'id' => $activityWorkflowStep->step_supervisor_id])->first();

            if($custodian) {
                #1- acceptance scenario
                //no special changes

                #2- rejection scenario
                if($request->status_id == Status::where('name', 'cancelled')->first()->id) {
                    
                    #change the beneficiary type to rejected
                    $this->changeBeneficiaryType($activityWorkflowStep, 'rejected');                    

                    #next there were no need for manager approval so change its status and description
                    ActivityWorkflowSteps::where('activitable_id', $activityWorkflowStep->activitable_id)
                        ->where('step_id', 7)->first()->update([

                            'description' => 'beneficiary rejected by custodian',
                            'status_id' => Status::where('name', 'rejected')->value('id'),

                            'modified_by' => auth()->user()->user_name,
                        ]);
                }

                #3- waiting for correction scenario
                /*no special changes => a custodian changes the status to waiting with useful description and 
                    makes call to the beneficiary tells him what to change.
                */
            }

            if($manager) {
                #1- acceptance scenario
                if($request->status_id == Status::where('name', 'approved')->first()->id) {
                    
                    #change the beneficiary type to approved
                    $this->changeBeneficiaryType($activityWorkflowStep, 'approved');
                }

                #2- rejection scenario
                if($request->status_id == Status::where('name', 'approved')->first()->id) {

                    #change the beneficiary type to rejected
                    $this->changeBeneficiaryType($activityWorkflowStep, 'rejected');
                }
            }

            //TODO: you may send notification to the beneficiary tells him about the new step here.

            return Message::response(true, 'activity step updated successfully..');
        });
    }

    /* ======== =========   ==========  =======
        d-r-y methods
    ======= ======*/
    private function changeBeneficiaryType(ActivityWorkflowSteps $activityWorkflowStep, string $beneficiaryType) {
        #change the beneficiary type to specified.
        $activitable = Activitable::find($activityWorkflowStep->activitable_id);
        #only works if it related to beneficiary processing
        $beneficiaryId = $activitable->activitable_id;
        $beneficiary = Beneficiary_Info::find($beneficiaryId);

        $specifiedBeneficiaryType = BeneficiaryType::where('name', $beneficiaryType)->first();
        if(!$specifiedBeneficiaryType) {return Message::response(true, 'create the beneficiary type [' . $beneficiaryType . '] first!!');}

        #change the type of the beneficiry
        $beneficiary->beneficiary_type()->associate($specifiedBeneficiaryType->id);
        $beneficiary->save();
    }
}
