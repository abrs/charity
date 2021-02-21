<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Activity extends Model
{
    use SoftDeletes, HasTranslations;

    public $translatable  = [
        'name'
    ];
    
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
            $builder->where('activities.is_enabled', 1);
        });
    }

    /**
     * ================
     * relations
     * =====
     */
    public function steps()
    {
        return $this->belongsToMany(Step::class, 'activity_workflow_steps', 'activity_id', 'step_id')
            ->withPivot('id','order_num', 'finishing_percentage', 'required', 'created_by')
            ->withTimestamps();
    }
}
