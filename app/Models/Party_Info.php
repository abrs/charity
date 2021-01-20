<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Party_Info extends Model
{
    use SoftDeletes;
    
    protected $table = 'party_infos';
    protected $with = ['type_info.user'];
    
    protected $fillable = [
        'type_infos_id', 
        'deleted_at', 
        'is_enabled', 
        'created_by',
        'modified_by', 
        'code'
    ];

    /** Relations ----------- */
    public function type_info() {
        return $this->belongsTo(Type_Info::class, 'type_infos_id');
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
