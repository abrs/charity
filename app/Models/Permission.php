<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as BasePermission;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Permission extends BasePermission
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'deleted_at', 
        'is_enabled', 
        'created_by', 
        'modified_by',
        'guard_name',
        'name',
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
            $builder->where('permissions.is_enabled', 1);
        });
    }
}
