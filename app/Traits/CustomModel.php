<?php

namespace App\Traits;

use App\Exceptions\JsonExceptionHandler;
use App\Helpers\Message;
use Illuminate\Database\Eloquent\Model;

Trait CustomModel{

    //first or update
    public function firstOrUpdate(array $exists, array $updatable): Model {
        
        $result = $this->where($exists)->first();

        if($result) {
            
            $message = Message::response(false, 'already exists with the specified ' . json_encode($exists));
            throw new JsonExceptionHandler($message);

        }else {

            $this->update(

                array_merge($exists, $updatable)
            );

            return $this;
        }
    }

    //already exists model
    public static function checkOrCreate(array $exists, array $extras) {
        
        $result = self::where($exists)->first();

        if($result) {
            
            $message = Message::response(false, 'already exists with the specified ' . json_encode($exists));
            throw new JsonExceptionHandler($message);

        }else {
                
            $object = self::create(

                array_merge($exists, $extras)
            );

            return $object;
        }
    }
}