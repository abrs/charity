<?php

namespace App\Models;

use App\Traits\EventsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Translatable\HasTranslations;

class Location extends Model
{
    use SoftDeletes, EventsTrait;//, HasTranslations;

    // protected $with = ['locationType'];

    // public $translatable  = [
    //     'name'
    // ];
    
    protected $fillable = [
        'point_id', 
        'name',
        'is_enabled', 
        'deleted_at', 
        'created_by',
        'modified_by', 
    ];

    // protected $with = ['point'];
    protected $hidden = ['point', 'pivot'];

    /** Relations ----------- */
    public function point() {
        return $this->belongsTo(Point::class);
    }

    public function locationType() {
        return $this->belongsToMany(LocationType::class, 'user_location', 'location_id', 'location_type_id')            
            ->withTimestamps();
    }

    public function beneficiaries() {
        return $this->hasMany(Beneficiary_Info::class);
    }


    /*=======   =========   ============
    |    extra functionality...         |
    =======   =========   ============*/
    public static function getModelAttributes($model) {

        $classAttributes = ['name', 'point_id'];
        $result = '';

        foreach($classAttributes as $attr){

            $result.= ($attr . ': ' . $model->$attr . ', ');
        }

        return $result;
    }
}
