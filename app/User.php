<?php

namespace App;

use App\Models\Type;
use App\Models\Type_Info;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_name', 'confirm_password',
        'deleted_at', 'is_enabled', 'created_by', 'modified_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = [
        'types', 'roles.permissions', 'type_infos'
    ];



    /**
     * =================== 
     * ======== Relations 
     * ==================================
     *  */
    public function types() {
        return $this->belongsToMany(Type::class, 'type_infos', 'user_id', 'type_id')->withTimestamps();
    }

    public function type_infos() {
        return $this->hasMany(Type_Info::class);
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
            $builder->where('users.is_enabled', 1);
        });
    }
}
