<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

class CustomModel extends Model{

    public function firstOrUpdate(array $exists, array $updatable): Model {
        
        return $this->where($exists)->firstOr(function() use ($exists, $updatable){

            $this->update(

                array_merge($exists, $updatable)
            );

            return $this;
        });
        
    }
}