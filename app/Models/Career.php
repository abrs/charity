<?php

namespace App\Models;

use App\Traits\EventsTrait;
use App\Traits\CustomModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career extends Model
{
    use SoftDeletes, EventsTrait, CustomModel;//, HasTranslations;

    // public $translatable  = [
    //     'name'
    // ];
    
    protected $fillable = [
        'name',
        'location_id', 
        'is_enabled', 
        'deleted_at', 
        'created_by',
        'modified_by', 
    ];


    /** Relations ----------- */
    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function beneficiaries() {
        return $this->hasMany(Beneficiary_Info::class);
    }


    /*=======   =========   ============
    |    extra functionality...         |
    =======   =========   ============*/
    public static function getModelAttributes($model) {

        $classAttributes = ['name', 'location_id'];
        $result = '';

        foreach($classAttributes as $attr){

            $result.= ($attr . ': ' . $model->$attr . ', ');
        }

        return $result;
    }
}
