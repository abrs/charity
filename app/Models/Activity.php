<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Translatable\HasTranslations;

class Activity extends Model
{
    use SoftDeletes;//, HasTranslations;

    // public $translatable  = [
    //     'name'
    // ];
    
    // protected $with = ['activitables'];

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
     * ================
     * relations
     * =====
     */
    public function activitables() {
        
        return $this->hasMany(Activitable::class);
    }
}
