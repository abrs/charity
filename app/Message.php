<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
class Message
{
    public static function response($result , $msg ='', $data=null) {

           if($data ==null)
           $data=[];
             else if (!$data instanceof  Collection)
             $data =[$data];

        return response()->json([
            'result' => $result ,
            'msg' => $msg,
            'data'=> $data
            ]);
      }
      public static function return($result, $data=null) {

        return array(
          'result' =>$result,
          'data' =>$data
        );

   }


}
