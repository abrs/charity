<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Event extends Model
{
    //
    use Notifiable;
    public function eventable()
    {
        return $this->morphTo();
    }

    public function to_eventable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // public function action()
    // {
    //     return $this->belongsTo('App\Action');
    // }
}