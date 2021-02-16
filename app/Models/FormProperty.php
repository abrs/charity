<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormProperty extends Model
{
    //
    public function property()
    {
        return $this->hasMany('App\Models\Property','form_properties');
    }
    
    public function form()
    {
        return $this->hasMany('App\Models\Form','form_properties');
    }

    
    public function input()
    {
        return $this->hasMany('App\Models\Input','field_form_inputs');
    }
}
