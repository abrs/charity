<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
    // use SoftDeletes;
    
    /**
     * The "booting" method of the model.
     *
     * @return void
     */

    protected $hidden = ['name_in_db','pivot','created_at','updated_at'];

    // public function formField()
    // {
    //     return $this->hasMany('App\Models\FormField');
    // }

    public function form()
    {
        return $this->belongsToMany('App\Models\Form','form_fields')->withPivot('value');
    }

    public function property()
    {
        return $this->morphToMany('App\Models\Property', 'propertyables');
    }


    // public function formField()
    // {
    //     return $this->hasMany('App\Models\FormField');
    // }

    public function formFieldValue()
    {
        return $this->hasMany('App\Models\FormFieldValue','field_id');
    }
    
}
