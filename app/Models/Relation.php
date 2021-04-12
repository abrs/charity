<?php

namespace App\Models;

use App\Traits\EventsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Translatable\HasTranslations;

class Relation extends Model
{
    use SoftDeletes, EventsTrait;//, HasTranslations;

    // public $translatable  = [
    //     'description',
    //     'name',
    // ];

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
