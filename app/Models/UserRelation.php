<?php

namespace App\Models;

use App\Traits\EventsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRelation extends Model
{
    use SoftDeletes, EventsTrait;
    
    protected $table = 'user_relations';
    protected $with = ['beneficiaries'];

    protected $fillable = [
        'relation_id',    
        'user_id',    
        'beneficiary_id',
        'family_budget',
        'is_enabled', 
        'deleted_at', 
        'created_by',
        'modified_by',
    ];


    /*=======   =========---============|
    |    extra functionality...         |
    =======   =========   ============*/
    public static function getModelAttributes($model) {

        $classAttributes = [
            'relation_id',    
            'user_id',    
            's_user_id',
            'family_budget',
        ];
        
        $result = '';

        foreach($classAttributes as $attr){

            $result.= ($attr . ': ' . $model->$attr . ', ');
        }

        return $result;
    }
}
