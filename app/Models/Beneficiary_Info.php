<?php

namespace App\Models;

use App\Traits\EventsTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Translatable\HasTranslations;

class Beneficiary_Info extends Model
{
    use SoftDeletes, EventsTrait;//, HasTranslations;

    // public $translatable  = [
    //     'first_name',
    //     'second_name',
    //     'third_name',
    //     'fourth_name',
    //     'last_name',
    //     'known_as',
    //     'career',
    //     'polling_station_name',
    //     'standing',
    // ];
    
    protected $table = 'beneficiary_infos';
    protected $with = ['locations'];



    protected $fillable = [
        'type_infos_id', 
        // 'location_id',
        'is_enabled', 
        'deleted_at', 
        'created_by',
        'modified_by',
        'first_name',
        'second_name',
        'third_name',
        'fourth_name',
        'last_name',
        'known_as',
        'career',
        'polling_station_name',
        'standing',
        'date_of_death',
        'is_special_needs',
        'birth',
        'gender',
        'national_number',
        'age',
        'is_alive',
        'special_needs_type_id',
    ];

    /** Relations ----------- */
    public function type_info() {
        return $this->belongsTo(Type_Info::class, 'type_infos_id');
    }
    public function locations() {
        // return $this->belongsTo(Location::class);
        return $this->belongsToMany(Location::class, 'user_location', 'user_id', 'location_id')
            ->withPivot('user_id', 'location_id', 'location_type_id', 'is_enabled', 'created_by')
            ->withTimestamps();
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('is_enabled', function (Builder $builder) {
            $builder->where('beneficiary_infos.is_enabled', 1);
        });
    }

    /*=======   =========   ============
    |    extra functionality...         |
    =======   =========   ============*/
    public static function getModelAttributes($model) {

        $classAttributes = [
            'type_infos_id', 
            'first_name',
            'second_name',
            'third_name',
            'fourth_name',
            'last_name',
            'known_as',
            'career',
            'polling_station_name',
            'standing',
            'date_of_death',
            'is_special_needs',
            'birth',
            'gender',
            'national_number',
            'age',
            'is_alive',
            'special_needs_type_id',
        ];

        $result = '';

        foreach($classAttributes as $attr){

            $result.= ($attr . ': ' . $model->$attr . ', ');
        }

        return $result;
    }
}
