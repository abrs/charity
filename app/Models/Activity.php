<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'name',
        'is_enabled', 
        'deleted_at', 
        'created_by',
        'modified_by', 
    ];
}