<?php

namespace App\Models;

use App\Traits\EventsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class BeneficiaryRelation extends Model
{
    use SoftDeletes, EventsTrait;
    
    protected $table = 'beneficiary_relations';

    protected $fillable = [
        'relation_id',    
        'beneficiary_id',    
        's_beneficiary_id',
        'family_budget',
        'is_enabled', 
        'deleted_at', 
        'created_by',
        'modified_by',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('is_enabled', function (Builder $builder) {
            $builder->where('beneficiary_relations.is_enabled', 1);
        });
    }

    /*=======   =========   ============
    |    extra functionality...         |
    =======   =========   ============*/
    public static function getModelAttributes($model) {

        $classAttributes = [
            'relation_id',    
            'beneficiary_id',    
            's_beneficiary_id',
            'family_budget',
        ];
        
        $result = '';

        foreach($classAttributes as $attr){

            $result.= ($attr . ': ' . $model->$attr . ', ');
        }

        return $result;
    }
}
