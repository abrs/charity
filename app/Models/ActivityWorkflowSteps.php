<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityWorkflowSteps extends Model
{
    use SoftDeletes;

    protected $table = 'activity_workflow_steps';

    protected $with = ['activitables'];

    protected $fillable = [
        'id',
        'activitable_id',    
        'step_id',    
        'step_supervisor_id',
        // 'step_supervisor_type',
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
    public function step_approval() {

        return $this->belongsToMany(Status::class, 'step_approvals')->withTimestamps();
    }

    public function activitables() {
        return $this->belongsTo(Activitable::class, 'activitable_id');
    }
}
