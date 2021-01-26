<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityBeneficiary extends Model
{
    use SoftDeletes;

    protected $table = 'activity_beneficiary';
    
    protected $fillable = [
        'activity_id',    
        'beneficiary_id',    
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
            $builder->where('activity_beneficiary.is_enabled', 1);
        });
    }
}
