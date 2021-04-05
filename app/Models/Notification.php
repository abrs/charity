<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification 
{
    public static function sendToUser($token, $title, $body, $data)
    {

        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $notification = [
            'title' => $title,
            'body' => $body,
            'data' => $data,
            'icon' => 'myIcon',
            'sound' => 'mySound',
        ];
        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to' => $token, //single token
//            'notification' => $notification,
            'notification' => $notification,
            'data' => $data,

        ];


        $headers = [
            'Authorization: key=' . 'AAAAAfRznrQ:APA91bFePTa3t8OC6WeaDY802XiCvAIRFG-Qt8Q-zPVADFQRzIX8KPDNwsbbBK2ZDqGJ0uxuIjyeatSg65__fwPbitwrnMVQWWiF2j37YLqCYOku4aMo0t-bCq9WjIL5Q4XIBS_oIs1p',
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;

    }
}
