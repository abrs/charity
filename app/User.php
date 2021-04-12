<?php

namespace App;

use App\Models\Relation;
use App\Models\Type;
use App\Models\Type_Info;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use Spatie\Translatable\HasTranslations;
use App\Traits\EventsTrait;

class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens, EventsTrait;//, HasTranslations;

    // public $translatable  = [
    //     'first_name', 'last_name'
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'first_name', 'last_name', 'email', 
        'password', 'user_name', 'confirm_password',
        'deleted_at', 'is_enabled', 'created_by', 'modified_by', 'email'
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

    // protected $with = [
    //     'types', 'roles.permissions', 'type_infos', 'relations'
    // ];


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

    //relations
    public function relations()
    {
        return $this->belongsToMany(Relation::class, 'user_relations', 'user_id', 'relation_id')
            ->withPivot('s_user_id', 'is_enabled', 'created_by')
            ->withTimestamps();
    }

    /*=======   =========   ============
    |    extra functionality...         |
    =======   =========   ============*/
    public static function getModelAttributes($model) {

        $classAttributes = ['user_name'];
        $result = '';

        foreach($classAttributes as $attr){

            $result.= ($attr . ': ' . $model->$attr . ', ');
        }

        return $result;
    }

    public function assignType(Type $type) {

        if(! $this->types->contains($type)) {

            $this->types()->save($type, [            
                'created_by' => auth()->user()->user_name,                    
            ]);
        }

        return Type_Info::where('user_id', $this->id)
            ->where('type_id', $type->id)->first();
    }
}
