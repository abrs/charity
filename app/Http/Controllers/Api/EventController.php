<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;

class EventController extends Controller
{
    //
    public function showAll(){

        return Message::response(
            true,
            'Events',
            Event::all()
        );
    }

    public function showById($id){

        try {

            $event = Event::findOrFail($id);

            return Message::response(
                true,
                'Event',
                $event->load('eventable')->get()
            );
            
        } catch (\Exception $e) {

            return Message::response(
                false,
                'error',
                $e->getMessage()
            );
            
        }

    }

    public function showByAction(Request $req){

        $validator = \Validator::make($req->all(), [
            'action_name' => ['required'],
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Message::response(
            true,
            'Action\'s Events',
            Event::where('action_name',$req->action_name)->get()
        );
    }

    public function showUserEvents($id){

        $user = User::find($id);
        
        if(!$user) {
            return Message::response(
                false, 'error', 'wrong user id!!'
            );
        }

        return Message::response(
            true,
            'User\'s Events',
            Event::where('user_id',$id)->get()
        );
    }

    public function showLastWeekEvent(){

        return Message::response(
            true,
            'Last Week Events',
            Event::whereDate('created_at', '>', Carbon::now()->subWeek())->get()
        );  
    }

    public function showLastMonthEvent(){

        return Message::response(
            true,
            'Last Month Events',
            Event::whereDate('created_at', '>', Carbon::now()->subMonth())->get()
        );  
    }

    public function showLastDayEvent(){

        return Message::response(
            true,
            'Last Day Events',
            Event::whereDate('created_at', '>=', Carbon::yesterday())->get()
        );  
    }

    public function showBetweenDaysEvent(Request $req)
    {
        $validator = \Validator::make($req->all(), [
            'startDate' => ['required'],
            'endDate' => ['required'],
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        $start = carbon::parse($req->startDate);
        $end = carbon::parse($req->endDate);
    
        return Message::response(
            true,
            'Events',
            Event::whereBetween('created_at', [$start,$end])->get()
        );
    }

    public function showAllModelEvents(Request $req){

        $validator = \Validator::make($req->all(), [
            'model_name' => ['required'],
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Message::response(
            true,
            'Model\'s Events',
            Event::where('eventable_type', 'App\Models\\' . ucfirst($req->model_name) )->get()
        );
    }

    public function delete($id){
        try{
            $event = Event::findOrFail($id);
            $event->delete();
            
            return Message::response(
                true,
                'Event ' .$id .' Deleted Successfully ' 
            );
           
        }catch ( \Illuminate\Database\QueryException $e){
            return  Message::response(false,'QueryException Error',$e->getMessage());
        
        }catch( \Exception $e){
            return  Message::response(false,'Something Error',$e->getMessage());
        }   
    }
}
