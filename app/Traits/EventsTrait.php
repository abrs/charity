<?php

namespace App\Traits;

use App\Models\Event;
use App\User;
use App\Helpers\Message;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
/**
 * 
 */
trait EventsTrait
{
    protected static function bootEventsTrait()
    {

        static::created(function ($model) {

            $action = 'Create';
            // if(Auth::guard('api')->user()) {

            return EventsTrait::addEvent($model, $action);            
            // }
        });

        static::updated(function ($model) {

            $action = 'Update';
            return EventsTrait::addEvent($model, $action);
                   
        });

        static::deleted(function ($model) {

            $action = 'Delete';
            return EventsTrait::addEvent($model, $action);
        });
     

    }

    public static function addEvent($model, $action){
        try{

            $userId = Auth::user()->id;
            $user = User::findOrFail($userId);
            $event = new Event();
            $event->user_id   = $userId;
            $event->action_name = $action;
            $event->message   = $user->user_name. ' ' . $action .'d ' . $model->getClass(). ' ' . $model->getModelAttributes($model);
            $model->events()->save($event);

        }catch(\Exception $e){
            return  Message::response(false,'Something Error In Add Event',$e->getMessage());
        }

    }

    /*=======   =========   ============
      relations...
    =======   =========   ============*/
    public function events()
    {
        return $this->morphMany(Event::class, 'eventable');
    }


    /*=======   =========   ============
        extra functionality...
    =======   =========   ============*/
    public function getClass() {
        
        return substr( __CLASS__, strrpos(__CLASS__, '\\', -1)+1);
    }
}