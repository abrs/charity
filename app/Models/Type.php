<?php

namespace App\Models;

use App\Traits\CustomModel;
use App\User;
use App\Traits\EventsTrait;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Spatie\Translatable\HasTranslations;

class Type extends Model
{
    use SoftDeletes, EventsTrait, CustomModel;

    // public $fieldName = 'name';


    // public $translatable  = [
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
        'name'
    ];

    /** Relations ----------- */
    public function users() {
        return $this->belongsToMany(User::class, 'type_infos', 'type_id', 'user_id');
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
