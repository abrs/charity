<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

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

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('is_enabled', function (Builder $builder) {
            $builder->where('is_enabled', 1);
        });
    }
}