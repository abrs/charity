<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Input extends Model
{
    //
    use SoftDeletes;

    protected $hidden = ['pivot'];

    public function property()
    {
        return $this->belongsTo('App\Models\Property');
    }

    // public function formField()
    // {
    //     return $this->hasMany('App\Models\FormField');
    // }

    // public function form()
    // {
    //     return $this->belongsToMany('App\Models\Form','form_fields');
    // }

    public function formFieldProperty()
    {
        return $this->belongsToMany('App\Models\Property','form_fields','input_id','property_id')->withPivot('value');
    }
}
