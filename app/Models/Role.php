<?php

namespace App\Models;

use App\Traits\EventsTrait;
use Spatie\Permission\Models\Role as BaseRole;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Role extends BaseRole
{
    use SoftDeletes, EventsTrait;

    // protected $table = 'roles';

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

    // protected $with = ['permissions'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function($model) {
            $model->guard_name = "web";
            $model->save();
        });

        static::addGlobalScope('is_enabled', function (Builder $builder) {
            $builder->where('roles.is_enabled', 1);
        });
    }

    /*=======   =========   ============
    |    extra functionality...         |
    =======   =========   ============*/
    public static function getModelAttributes($model) {

        $classAttributes = ['name'];
        $result = '';

        foreach($classAttributes as $attr){

            $result.= ($attr . ': ' . $model->$attr . ', ');
        }

        return $result;
    }
}
