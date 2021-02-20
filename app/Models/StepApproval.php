<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Step;
use App\Models\Activity;
use ActivityWorkflowSteps;

class StepApproval extends Model
{
    use SoftDeletes;

    protected $table = 'step_approvals';
    
    protected $fillable = [
        'activity_workflow_steps_id', 
        'user_id',
        'owner_id',
        'status_id',
        'note',
        
        'is_enabled', 
        'deleted_at', 
        'created_by',
        'modified_by', 
    ];

     /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('is_enabled', function (Builder $builder) {
            $builder->where('step_approvals.is_enabled', 1);
        });
    }

    protected function updatePrevStepStatus($owner_id,$activity_id,$step_id){

        $status = Status::where('name','approved')->first();        
        
        $prevStep = StepApproval::getPrevStep($step_id,$activity_id);
        if($prevStep == null) return null;
        $prevActivityWorkflowStepId = ActivityWorkflowSteps::where([
                                                                'activity_id' => $activity->id,
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
        $stepOrderNumber = $step->activities->where('id',$activity_id)->first()->pivot->order_num;
        if($stepOrderNumber > 1){
            do{
                $prevStep = Step::whereHas('activities',function($q)use($stepOrderNumber,$activity_id){
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
        $stepOrderNumber = $step->activities->where('id',$activity_id)->first()->pivot->order_num;
        
        if($stepOrderNumber == $activity->step->count()){  
            return null;
        }else{
            $nextStep = Step::where('optional','!=',1)
                            ->whereHas('activities',function($q)use($stepOrderNumber){
                                                            $q->where('activities.id',$activity_id)
                                                              ->where('order_num',$stepOrderNumber+1);
                                                        })->first();
            return $nextStep;
        };
    }
}
