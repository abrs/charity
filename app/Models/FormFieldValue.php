<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormFieldValue extends Model
{
    //
    protected $table = 'form_field_values';

    public function formField()
    {
        return $this->belongsTo('App\Models\FormField');
    }
}
