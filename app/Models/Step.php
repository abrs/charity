<?php

namespace App\Models;

use App\Traits\CustomModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Translatable\HasTranslations;

class Step extends Model
{
    use SoftDeletes, CustomModel;//, HasTranslations;
    
    // public $translatable  = [
    //     'description',
    //     'name'
    // ];

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
     * ================
     * relations
     * =====
     */
    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_workflow_steps', 'step_id', 'activity_id')
            ->withPivot('id','order_num', 'finishing_percentage', 'required', 'created_by')
            ->withTimestamps();
    }
}
