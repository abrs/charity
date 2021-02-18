<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Location extends Model
{
    use SoftDeletes, HasTranslations;

    public $translatable  = [
        'name'
    ];
    
    protected $fillable = [
        'point_id', 
        'name',
        'is_enabled', 
        'deleted_at', 
        'created_by',
        'modified_by', 
    ];

    protected $with = ['point'];

    /** Relations ----------- */
    public function point() {
        return $this->belongsTo(Point::class);
    }

    public function beneficiaries() {
        return $this->hasMany(Beneficiary_Info::class);
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
            $builder->where('locations.is_enabled', 1);
        });
    }
}
