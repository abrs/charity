<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Translatable\HasTranslations;

class LocationType extends Model
{
    use SoftDeletes;//, HasTranslations;

    protected $table = "location_types";

    // public $translatable  = [
    //     'name'
    // ];

    protected $fillable = [
        'name',
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
            $builder->where('location_types.is_enabled', 1);
        });
    }
}
