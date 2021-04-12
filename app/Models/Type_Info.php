<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\EventsTrait;

class Type_Info extends Model
{
    use SoftDeletes, EventsTrait;

    // public $fieldName = 'name';
    
    protected $table = 'type_infos';
    protected $with = ['beneficiary_info'];

    protected $fillable = [
        'deleted_at', 
        'is_enabled', 
        'created_by', 
        'modified_by', 
        'user_id',
        'type_id',
    ];

    /** Relations ----------- */
    public function party_info() {
        return $this->hasOne(Party_Info::class, 'type_infos_id');
    }

    public function beneficiary_info() {
        return $this->hasOne(Beneficiary_Info::class, 'type_infos_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }


    /*=======   =========   ============
    |    extra functionality...         |
    =======   =========   ============*/
    public static function getModelAttributes($model) {

        $classAttributes = ['user_id', 'type_id'];
        $result = '';

        foreach($classAttributes as $attr){

            $result.= ($attr . ': ' . $model->$attr . ', ');
        }

        return $result;
    }
}
