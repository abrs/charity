<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Beneficiary_Info extends Model
{
    use SoftDeletes, HasTranslations;

    public $translatable  = [
        'first_name',
        'second_name',
        'third_name',
        'fourth_name',
        'last_name',
        'known_as',
        'career',
        'polling_station_name',
        'standing',
    ];
    
    protected $table = 'beneficiary_infos';
    protected $with = ['locations', 'relations'];



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
        'email',
        'is_alive',
        'special_needs_type_id',
    ];

    /** Relations ----------- */
    public function type_info() {
        return $this->belongsTo(Type_Info::class, 'type_infos_id');
    }
    public function locations() {
        // return $this->belongsTo(Location::class);
        return $this->belongsToMany(Location::class, 'beneficiary_location', 'beneficiary_id', 'location_id')
            ->withPivot('beneficiary_id', 'location_id', 'location_type_id', 'is_enabled', 'created_by')
            ->withTimestamps();
    }

    public function relations()
    {
        return $this->belongsToMany(Relation::class, 'beneficiary_relations', 'beneficiary_id', 'relation_id')
            ->withPivot('s_beneficiary_id', 'is_enabled', 'created_by')
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
}
