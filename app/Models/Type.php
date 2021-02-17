<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Translatable\HasTranslations;

class Type extends Model
{
    use SoftDeletes, HasTranslations;

    public $translatable  = [
        'name'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'deleted_at', 
        'is_enabled', 
        'created_by', 
        'modified_by', 
        'name'
    ];

    /** Relations ----------- */
    public function users() {
        return $this->belongsToMany(User::class, 'type_infos', 'type_id', 'user_id');
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
            $builder->where('types.is_enabled', 1);
        });
    }
}
