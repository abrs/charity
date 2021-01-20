<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityBeneficiary extends Model
{
    protected $table = 'activity_beneficiary';
    
    protected $fillable = [
        'activity_id',    
        'beneficiary_id',    
        'is_enabled', 
        'deleted_at', 
        'created_by',
        'modified_by',
    ];
}
