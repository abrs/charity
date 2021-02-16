<?php

namespace App\Http\Controllers\Api;


use App\helpers\Message;
use App\Models\Input;
use App\Models\Form;
use App\Models\FormFieldValue;
use App\Models\ActivityWorkflowSteps;
use App\Models\Step;
use App\Models\Activity;
use App\Models\StepApproval;
use App\Models\Status;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Validator;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Message::response(
            true,
            'done',
            Form::paginate(25)
        );
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
            'name' => ['required', 'unique:forms'],
        ]);

        if ($validator->fails()) {
            return Message::response(false, 'Invalid Input', $validator->errors());
        }

        $form = Form::firstOrcreate([
            'name' => $request->name,
        ]);

        return Message::response(true, 'created', $form);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {

        $form = Form::with('field.property')->where('id',$form->id)->first();
        foreach($form->field as $field){

            foreach($field->property as $property){

                $inputs = Input::whereHas('formFieldProperty',function($q)use($form,$field,$property){
                    $q->where('form_id',$form->id)
                      ->where('field_id',$field->id)
                      ->where('property_id',$property->id);
                })->get();
                foreach($inputs as $input)
                {
                    foreach($input->formFieldProperty as $prop)
                    {
                        $input->value = $prop->pivot->where('form_id',$form->id)
                                                    ->where('field_id',$field->id) 
                                                    ->value('value');
                    }                                                      
                }

                $property->input = $inputs;
            }
        }
        return Message::response('true', 'done', $form);
    }

    
    public function showWaitingBeneficiaryForm()
    {

        $ownerIdsArr = [];
        $steps = Step::all();
        $beneficiaryFormArray = [];
        $form = Form::where('name','استمارة مستفيد')->first();
        $statusId = Status::where('name','approved')->first()->id;
        $activity = Activity::where('name','add_new_beneficiary')->first();
        
       
        $activityWorkflowStepId1 = ActivityWorkflowSteps::where([
                                                                'activity_id' => $activity->id,
                                                                'step_id' => $steps->where('name','تعبئة الاستمارة')->first()->id,
                                                            ])->first()->id;

        $activityWorkflowStepId2 = ActivityWorkflowSteps::where([
                                                                'activity_id' => $activity->id,
                                                                'step_id' => $steps->where('name','موافقة الخادم')->first()->id,
                                                            ])->first()->id;

        $ownerIds = StepApproval::where([
                                            'activity_workflow_steps_id' => $activityWorkflowStepId1,
                                            'status_id' => $statusId
                                        ])->pluck('owner_id')->toArray();
                        
        

        for($i=0; $i<count($ownerIds);$i++){

            $stepApproval = StepApproval::where([
                                                'owner_id' => $ownerIds[$i],
                                                'activity_workflow_steps_id' => $activityWorkflowStepId2,
                                            ])->get();

            if($stepApproval->count() == 0){
                array_push($ownerIdsArr,$ownerIds[$i]);
            }else if($stepApproval->count() > 0)
            {
                $waitingStatusId = Status::where('name','waiting')->first()->id;
                $count = $stepApproval->count();
                $statusId = $stepApproval[$count-1]->status_id;
                if($statusId == $waitingStatusId){
                    array_push($ownerIdsArr,$ownerIds[$i]);
                }
            }
            
        }

        for($i=0; $i<count($ownerIdsArr);$i++)
        {
            $formFieldValue = Form::where('id',$form->id)->with(array('field.formFieldValue' => function($q)use($ownerIdsArr,$i){
                $q->where('form_field_values.owner_id',$ownerIdsArr[$i]);
            }))->get();

            array_push($beneficiaryFormArray,$formFieldValue);
        }
        
        return Message::response(
            true,
            'done',
            $beneficiaryFormArray
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $form)
    {
        $validator = \Validator::make($request->all(), [
            'name' => ['required', 'unique:forms'],
        ]);

        if ($validator->fails()) {
            return Message::response(false, 'Invalid Input', $validator->errors());
        }

        $form->update([
            'name' => $request->name,
        ]);

        return Message::response(true, 'updated', Form::findOrFail($form->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        $form->delete();
        return Message::response(true, 'deleted');
    }

    public function submitForm(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'form_id' => 'required|numeric|exists:forms,id',
            'owner_id' => 'required|numeric|exists:users,id',
            'fields' => 'required|array',
            'fields.*.id' => ['required',Rule::exists('form_fields')->where(function ($query) use($request) {
                $query->where('form_id', $request->form_id);
            })],
            'fields.*.value' => 'required'
        ]);

        if ($validator->fails()) {
            return Message::response(false, 'Validation Error', $validator->errors());
        }
        try{

            $reSubmit = false;
            $activity = Activity::where('name','add_new_beneficiary')->first();
            // $step = Step::where('name','تعبئة الاستمارة')->first();
            // $editStep = Step::where('name','طلب تعديل الاستمارة')->first();
            // $reSubmitStep = Step::where('name','إعادة ارسال الاستمارة')->first();
            $steps = Step::all();
            $stepOrderNumber = $steps->where('name','تعبئة الاستمارة')->first()->activities->where('name','add_new_beneficiary')->first()->pivot->order_num;
            $statusId = Status::where('name','waiting')->first()->id;
            $approvedStatusId = Status::where('name','approved')->first()->id;

            $activityWorkflowStepId1 = ActivityWorkflowSteps::where([
                                                                    'activity_id' => $activity->id,
                                                                    'step_id' => $steps->where('name','تعبئة الاستمارة')->first()->id
                                                                ])->first()->id;

            $activityWorkflowStepId2 = ActivityWorkflowSteps::where([
                                                                    'activity_id' => $activity->id,
                                                                    'step_id' => $steps->where('name','موافقة الخادم')->first()->id
                                                                ])->first()->id;

            $activityWorkflowStepId3 = ActivityWorkflowSteps::where([
                                                                    'activity_id' => $activity->id,
                                                                    'step_id' => $steps->where('name','طلب تعديل الاستمارة')->first()->id
                                                                ])->first()->id;
            if($stepOrderNumber > 1){
                $prevStep = Step::where('optional','!=',1)->whereHas('activities',function($q)use($stepOrderNumber){
                    $q->where('activities.name','add_new_beneficiary')
                      ->where('order_num',$stepOrderNumber-1);
                })->with(array('activities' => function($q){
                    $q->where('name','add_new_beneficiary');
                }))->first();


                $prevActivityWorkflowStepId = ActivityWorkflowSteps::where([
                                                                    'activity_id' => $activity->id,
                                                                    'step_id' => $prevStep->id
                                                                ])->first()->id;

                
               
                $prevStepApproval = StepApproval::where([
                                                        'owner_id' => $request->owner_id,
                                                        'activity_workflow_steps_id' => $prevActivityWorkflowStepId,
                                                        // 'status_id' => $statusId
                                                    ])->get();
                
                

                $count = $prevStepApproval->count();
                if($count == 0)
                {
                   return Message::response(false ,'عليك القيام بالخطوة السابقة أولاً:  ' . $prevStep->name);
                }

            }
           
            $submitArray = array();
            
            foreach($request->fields as $field) {

                $existed = FormFieldValue::where([
                                                  'form_id' => $request->form_id,
                                                  'field_id'=>$field['id'],
                                                  'owner_id'=>$request->owner_id
                                                ])->first();

                if($existed)
                {

                    $stepApproval = StepApproval::where([
                                                        'owner_id' => $request->owner_id,
                                                        'activity_workflow_steps_id' => $activityWorkflowStepId2,
                                                    ])->where('status_id','!=',$statusId)->get();                                                    
                    
                    if($stepApproval->count() != 0)
                    {
                        return Message::response( false ,'لا يمكنك التعديل على الاستمارة');
                    }else
                    {
                        $resubmitStepApproval = StepApproval::Where([
                                                        'owner_id' => $request->owner_id,
                                                        'activity_workflow_steps_id' => $activityWorkflowStepId3,
                                                        'status_id' => $approvedStatusId
                                                ])->first();

                        if($resubmitStepApproval != null)
                        {
                            $reSubmit = true;
                        }
                        $formFieldValue = FormFieldValue::where([
                                                                'form_id' => $request->form_id,
                                                                'owner_id'=>$request->owner_id
                                                            ])->delete();
                    }
                    
                }
               
               //
                $fieldValue = array();

                $fieldValue['form_id'] = $request->form_id;
                $fieldValue['field_id'] = $field['id'];
                $fieldValue['user_id'] = $request->user()->id;
                $fieldValue['value'] = $field['value'];
                $fieldValue['owner_id'] = $request->owner_id;
                array_push($submitArray,$fieldValue);
                
            }

            FormFieldValue::insert($submitArray);

            if($reSubmit == false)
            {
                $newStepApproval = StepApproval::firstOrCreate([
                    'owner_id' => $request->owner_id,
                    'activity_workflow_steps_id' => $activityWorkflowStepId1,
                    'status_id' => $approvedStatusId,
                    'is_enabled' => 1
                ],['user_id' => $request->user()->id]);

                // $update = StepApproval::updatePrevStepStatus($request->owner_id,$activity->id,$step->id);
                
            }else{
                $resubmitctivityWorkflowStepId = ActivityWorkflowSteps::where([
                                                                    'activity_id' => $activity->id,
                                                                    'step_id' => $steps->where('name','إعادة ارسال الاستمارة')->first()->id
                                                                ])->first()->id;
                
                $newStepApproval = StepApproval::firstOrCreate([
                    'owner_id' => $request->owner_id,
                    'activity_workflow_steps_id' => $resubmitctivityWorkflowStepId,
                    'status_id' => $approvedStatusId,
                    'is_enabled' => 1
                ],['user_id' => $request->user()->id]
            );

                // $update = StepApproval::updatePrevStepStatus($request->owner_id,$activity->id,$step->id);

            }


        }
        catch (\Exception $e) {
            return Message::response(false ,'Catch error',$e->getMessage() );
        }
        return Message::response(true ,'form submitted successfully' );
    }

    public function beneficiaryDecision(Request $request, Form $form)
    {
        $validator = \Validator::make($request->all(), [
        ]);

        if ($validator->fails()) {
            return Message::response(false, 'Invalid Input', $validator->errors());
        }

        $custodianRole = false;
        $managerRole = false;
        $roleIds = null;
        $userId = $request->user()->id;
        $roles = User::find($userId)->roles;
        $activity = Activity::where('name','add_new_beneficiary')->first();
        $step = Step::where('name','موافقة الخادم')->first();
        //$custodianRoleId = Role::where('name','custodian')->first()->id;

        //Check if previous step was done

        $prevStep = StepApproval::getPrevStep($step->id,$activity->id);

        $prevActivityWorkflowStepId = ActivityWorkflowSteps::where([
                                                                    'activity_id' => $activity->id,
                                                                    'step_id' => $prevStep->id
                                                                ])->first()->id;



        $prevStepApproval = StepApproval::where([
                                                'owner_id' => $request->owner_id,
                                                'activity_workflow_steps_id' => $prevActivityWorkflowStepId,
                                            ])->get();

        $count = $prevStepApproval->count();

        if($count == 0)
        {
           return Message::response(false ,'عليك القيام بالخطوة السابقة أولاً:  ' . $prevStep->name);
        }

        foreach($roles as $role)
        {
            if($role->name == 'custodian'){
                $custodianRole = true;
            }

            if($role->name == 'manager'){
                $managerRole = true;
            }
        }

        if($custodianRole == false && $managerRole == false){
            return Message::response(false, 'You do not have a permission', Form::findOrFail($form->id));
        }
        if($custodianRole == true){
            $reSubmit = false;

            $prevStepApproval = StepApproval::where([
                                                    'owner_id' => $request->owner_id,
                                                    'activity_workflow_steps_id' => $prevActivityWorkflowStepId,
                                                ])->get();

        }

        

        return Message::response(true, 'updated', Form::findOrFail($form->id));
    }
}
