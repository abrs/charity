<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Party_Info extends Model
{
    protected $table = 'party_infos';
    
    protected $fillable = [
        'type_infos_id', 
        'deleted_at', 
        'is_enabled', 
        'created_by',
        'modified_by', 
        'code'
    ];
}
