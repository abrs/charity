<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beneficiary_Info extends Model
{
    use SoftDeletes;
    
    protected $table = 'beneficiary_infos';
    protected $with = ['location', 'type_info.user', 'activities'];

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
        return $this->belongsToMany(Activity::class, 'activity_beneficiary', 'beneficiary_id', 'activity_id')->withTimestamps();
            //  ->using(ActivityBeneficiary::class);
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
            $builder->where('is_enabled', 1);
        });
    }
}
