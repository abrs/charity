<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'name',
        'is_enabled', 
        'deleted_at', 
        'created_by',
        'modified_by', 
    ];

    //makes loop if activities from Beneficiary_Info is active.
    // protected $with = ['beneficiaries'];

    /** Relations ----------- */
    public function beneficiaries()
    {
        return $this->belongsToMany(Beneficiary_Info::class, 'activity_beneficiary', 'activity_id', 'beneficiary_id')->withTimestamps();
            // ->using(ActivityBeneficiary::class);
    }
}