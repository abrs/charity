<?php

namespace App\Models;

use App\Traits\EventsTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
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
    // protected $with = ['locations'];
    protected $hidden = ['type_infos_id'];
    // protected $appends = ['special_needs_type'];
    // protected $casts = ['is_special_needs' => 'boolean',];



    protected $fillable = [
        'type_infos_id', 
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
        'polling_station_id',
        'standing',
        'date_of_death',
        'is_special_needs',
        'birth',
        'gender',
        'national_number',
        'age',
        'is_alive',
        'beneficiary_type_id',
        'phone',
    ];

    /** Relations ----------- */
    public function type_info() {
        return $this->belongsTo(Type_Info::class, 'type_infos_id');
    }

    public function special_needs() {

        return $this->belongsToMany(SpecialNeedType::class, 'beneficiary_special_needs_types', 
            'beneficiary_id', 'special_needs_type_id')
                ->withTimestamps();
    }

    //relations
    public function relations()
    {
        return $this->belongsToMany(User::class, 'user_relations', 'beneficiary_id', 'user_id')
            ->withPivot('beneficiary_id', 'is_enabled', 'created_by')
            ->withTimestamps();
    }

    /**
     * Get all of the beneficiary's activitables.
     */
    public function activitables()
    {
        return $this->morphMany(Activitable::class, 'activitable');        
    }

    public function beneficiary_type() {
        return $this->belongsTo(BeneficiaryType::class);
    }


    /*=======   =========   ============
    |    extra functionality...         |
    =======   =========   ============*/
    public function getUser() {
        return $this->type_info->user;
    }


    // public function getSpecialNeedsTypeAttribute()
    // {
    //     return SpecialNeedType::find($this->special_needs_type_id)->name;
    // }

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
            'polling_station_id',
            'standing',
            'date_of_death',
            'is_special_needs',
            'birth',
            'gender',
            'phone',
            'national_number',
            'age',
            'is_alive',
        ];

        $result = '';

        foreach($classAttributes as $attr){

            $result.= ($attr . ': ' . $model->$attr . ', ');
        }

        return $result;
    }
}
