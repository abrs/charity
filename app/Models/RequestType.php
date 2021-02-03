<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RequestType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kind_id', 
        'name',
        'max_days',
        'max_hours',
        'note',
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
            $builder->where('request_types.is_enabled', 1);
        });
    }

    public function types() {
        return $this->belongsToMany(Type::class, 'req_to_approved', 'request_type_id', 'type_id')
            ->withTimestamps();
    }
}
