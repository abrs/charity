<?php

namespace App\Models;

use App\Traits\CustomModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Translatable\HasTranslations;

class Status extends Model
{
    use SoftDeletes, CustomModel;//, HasTranslations;

    // public $translatable  = [
    //     'name'
    // ];
    
    public $timestamps= false;
    
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

}
