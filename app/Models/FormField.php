<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    //

    protected $table = 'form_fields';
    protected $hidden = ['field_id','form_id','property_id','input_id'];

    public function form()
    {
        return $this->belongsTo('App\Models\Form');
    }

    public function field()
    {
        return $this->belongsTo('App\Models\Field');
    }

    public function property()
    {
        return $this->belongsTo('App\Models\Property');
    }

    public function input()
    {
        return $this->belongsTo('App\Models\Input');
    }

    
    

   
}
