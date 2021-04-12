<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    // use SoftDeletes;
    
    protected $fillable = ['name'];
    protected $hidden =['created_at','updated_at'];
    /**
     * The "booting" method of the model.
     *
     * @return void
     */

    
    // public function formField()
    // {
    //     return $this->hasMany('App\Models\FormField');
    // }

    public function field()
    {
        return $this->belongsToMany('App\Models\Field','form_fields')->withPivot('value');
    }

    public function property()
    {
        return $this->morphToMany('App\Models\Property','propertyables');
    }

    public function input()
    {
        return $this->belongsToMany('App\Models\Input','form_fields');
    }

}
