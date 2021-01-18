<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Type extends Model
{
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
}
