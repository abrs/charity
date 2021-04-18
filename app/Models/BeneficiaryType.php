<?php

namespace App\Models;

use App\Traits\EventsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BeneficiaryType extends Model
{
    use SoftDeletes, EventsTrait;
    
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
    public function beneficiary_infos() {
        return $this->hasMany(Beneficiary_Info::class, 'beneficiary_type_id');
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
