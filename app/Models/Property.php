<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    //

    protected $hidden = ['created_at','updated_at','pivot'];

    public function form()
    {
        return $this->morphedByMany('App\Models\Form', 'propertyables');
    }

    public function field()
    {
        return $this->morphedByMany('App\Models\Field', 'propertyables');
    }

    // public function formField()
    // {
    //     return $this->hasMany('App\Models\FormField');
    // }

    public function input()
    {
        return $this->hasMany('App\Models\Input');
    }

    public function formFieldInput()
    {
        return $this->belongsToMany('App\Models\Input','form_fields','property_id','input_id')->withPivot('value');
    }


}
