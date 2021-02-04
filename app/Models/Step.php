<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Step extends Model
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
        'description',
        'name'
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
            $builder->where('steps.is_enabled', 1);
        });
    }

    /**
     * ================
     * relations
     * =====
     */
    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_workflow_steps', 'step_id', 'activity_id')
            ->withPivot('order_num', 'finishing_percentage', 'required', 'created_by')
            ->withTimestamps();
    }
}
