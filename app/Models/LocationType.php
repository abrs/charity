<?php

namespace App\Models;

use App\Traits\CustomModel;
use App\Traits\EventsTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Translatable\HasTranslations;

class LocationType extends Model
{
    use SoftDeletes, EventsTrait, CustomModel;//, HasTranslations;

    protected $table = "location_types";

    protected $hidden = ['pivot'];

    // public $translatable  = [
    //     'name'
    // ];

    protected $fillable = [
        'name',
        'is_enabled', 
        'deleted_at', 
        'created_by',
        'modified_by', 
    ];

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
