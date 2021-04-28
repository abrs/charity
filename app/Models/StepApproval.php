<?php

namespace App\Models;

use App\Traits\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Step;
use App\Models\Activity;
use App\Models\ActivityWorkflowSteps;

class StepApproval extends Model
{
    use SoftDeletes, CustomModel;

    protected $table = 'step_approvals';

    protected $with = ['activityWorkflowStep'];

    protected $fillable = [
        'activity_workflow_steps_id', 
        // 'user_id',
        // 'owner_id',
        'status_id',
        'note',
        'description',
        
        'is_enabled', 
        'deleted_at', 
        'created_by',
        'modified_by', 
    ];

    /* =====    ========    ========
        relations
    */
    public function activityWorkflowStep() {
        return $this->belongsTo(ActivityWorkflowSteps::class, 'activity_workflow_steps_id')
            //get me only steps belongs to my roles
            ->whereIn('step_supervisor_id', \Auth::user()->roles->pluck('id')->all());
            // ->where('order_num', ActivityWorkflowSteps::min('order_num'))
            // ->where('status', $this->selectedStatus);
    }
    

    /*  ==========================
        extra functionality
    = */
    protected function updatePrevStepStatus($owner_id,$activity_id,$step_id){

        $status = Status::where('name','approved')->first();        
        
        $prevStep = $this->getPrevStep($step_id,$activity_id);
        if($prevStep == null) return null;
        $prevActivityWorkflowStepId = ActivityWorkflowSteps::where([
            'activity_id' => $activity_id,
            'step_id' => $prevStep->id
        ])->first()->value('id');

        StepApproval::where([
            'owner_id' => $owner_id,
            'activity_workflow_steps_id' => $prevActivityWorkflowStepId
        ])->update(['sataus' => $status->id]);
        
        return true;
    }

    protected function getPrevStep($step_id,$activity_id)
    {
        $isOptional = false;
        $step = Step::where('id',$step_id)->first();
        $stepOrderNumber = $step->activities()->where('id',$activity_id)->first()->pivot->order_num;
        if($stepOrderNumber > 1){
            do{
                $prevStep = Step::whereHas('activities',function($q)use($stepOrderNumber, $activity_id){
                    $q->where('activities.id',$activity_id)
                      ->where('order_num',$stepOrderNumber-1);
                })->first();
                if($prevStep->optional == 1) $isOptional = true;
            }while($isOptional == true);

            return $prevStep;
        }else return null;
    }

    protected function getNextStep($step_id,$activity_id)
    {
        $step = Step::where('id',$step_id)->first();
        $activity = Activity::find($activity_id);
        $stepOrderNumber = $step->activities()->where('id',$activity_id)->first()->pivot->order_num;
        
        if($stepOrderNumber == $activity->step->count()){  
            return null;
        }else{
            $nextStep = Step::where('optional','!=',1)
                ->whereHas('activities',function($q) use ($stepOrderNumber, $activity_id){
                    $q->where('activities.id',$activity_id)
                        ->where('order_num',$stepOrderNumber+1);
                })->first();
            return $nextStep;
        };
    }
}
