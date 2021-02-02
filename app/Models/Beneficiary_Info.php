<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beneficiary_Info extends Model
{
    use SoftDeletes;
    
    protected $table = 'beneficiary_infos';
    protected $with = ['location', 'activities', 'relations'];

    protected $fillable = [
        'type_infos_id', 
        'location_id',
        'is_enabled', 
        'deleted_at', 
        'created_by',
        'modified_by', 
    ];

    /** Relations ----------- */
    public function type_info() {
        return $this->belongsTo(Type_Info::class, 'type_infos_id');
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_beneficiary', 'beneficiary_id', 'activity_id')
            // ->withPivot('name')
            ->withTimestamps();
    }

    public function relations()
    {
        return $this->belongsToMany(Relation::class, 'beneficiary_relations', 'beneficiary_id', 'relation_id')
            // ->as('relations')
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
