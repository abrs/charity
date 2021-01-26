<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Relation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'code',
        // 's_beneficiary_id',
        'deleted_at', 
        'is_enabled', 
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
            $builder->where('relations.is_enabled', 1);
        });
    }
}
