<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Propertyable extends Model
{
    //
    protected $table = 'propertyable';

    public function formField()
    {
        return $this->hasmany('App\Models\FormField');
    }

    public function property()
    {
        return $this->belongsTo('App\Property');
    }
}
