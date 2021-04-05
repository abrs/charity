<?php

namespace App\Helpers;

class Tenant {

    public static function wrapTenant(callable $function) {
    
        // $result = tenant()->run(function () use ($function){
    
        try {
            
            return $function();
            
        } catch (\Exception $e) {
            return $e;
            // return Message::response(false,'Invalid Input' ,$e->getMessage());
        }
        // });
    
        // return $result;
    }
}