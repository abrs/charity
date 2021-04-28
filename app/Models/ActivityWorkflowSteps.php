<?php

namespace App\Models;

use App\Traits\CustomModel;
use App\Traits\EventsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityWorkflowSteps extends Model
{
    use SoftDeletes, EventsTrait, CustomModel;

    protected $table = 'activity_workflow_steps';

    protected $with = ['activitable', 'step'];

    protected $fillable = [
        'id',
        'activitable_id',    
        'step_id',    
        'step_supervisor_id',
        'status_id',
        'description',
        'order_num',
        'finishing_percentage',
        'required',
        'is_enabled', 
        'deleted_at', 
        'created_by',
        'modified_by',
    ];

    #===============
    //=== relations
    #=============
    // public function step_approval() {

    //     return $this->belongsToMany(Status::class, 'step_approvals')->withTimestamps();
    // }

    public function activitable() {
        return $this->belongsTo(Activitable::class, 'activitable_id');
    }

    public function step() {
        return $this->belongsTo(Step::class, 'step_id');
    }

    public function status() {
        return $this->belongsTo(Status::class, 'status_id');
    }

        /*=======   =========   ============
    |    extra functionality...         |
    =======   =========   ============*/
    public static function getModelAttributes($model) {

        $classAttributes = ['status_id','description'];
        $result = '';

        foreach($classAttributes as $attr){

            $result.= ($attr . ': ' . $model->$attr . ', ');
        }

        return $result;
    }
}
