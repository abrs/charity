<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldProperty extends Model
{
    //
    protected $table = 'field_properties';

    public function formField()
    {
        return $this->hasMany('App\Models\FormField');
    }

    public function property()
    {
        return $this->hasMany('App\Models\Property','field_properties');
    }
    
    public function form()
    {
        return $this->hasMany('App\Models\Form','field_properties');
    }



    public function input()
    {
        return $this->hasMany('App\Models\Input','field_form_inputs');
    }
}
