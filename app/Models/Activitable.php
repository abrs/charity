<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activitable extends Model
{
    protected $table = 'activitable';

    protected $with = ['activity', 'beneficiary'];

    protected $fillable = ['activitable_id', 'activitable_type'];

    /**
     * Get the owning activitable model.
     */
    public function activitable() {

        return $this->morphTo();
    }

    public function activity() {
        return $this->belongsTo(Activity::class);
    }

    public function beneficiary() {
        return $this->belongsTo(Beneficiary_Info::class, 'activitable_id');
    }

    // public function steps() {

    //     return $this->belongsToMany(Step::class, 'activity_workflow_steps', 'activitable_id', 'step_id')
    //         ->withPivot('id','order_num', 'finishing_percentage', 'required', 'created_by')
    //         ->withTimestamps();
    // }
}
