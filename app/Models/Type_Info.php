<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type_Info extends Model
{
    protected $table = 'type_infos';

    protected $fillable = [
        'deleted_at', 
        'is_enabled', 
        'created_by', 
        'modified_by', 
        'user_id',
        'type_id',
    ];
}
