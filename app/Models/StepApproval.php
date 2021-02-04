<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StepApproval extends Model
{
    use SoftDeletes;

    protected $table = 'step_approvals';
    
    protected $fillable = [
        'activity_workflow_steps_id', 
        'user_id',
        'owner_id',
        'status_id',

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
}
