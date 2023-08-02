<?php

namespace App\Notifications;

use Illuminate\Support\Facades\Http;


class PushNotification
{
    public static function send($reciever, $screen, $message, $notification_data = null, $type = null)
    {
        $friendLocale = $reciever->lng;
        app()->setLocale($friendLocale);

        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = env('FCM_KEY') ?? 'AAAAGIXjgfY:APA91bGtS4VfEcC3r90nHGBG_0bTzszhSYgl2UwE1W3SitQjgbkPHle7fwaerx27RNeKY2szc0WAMzEvDHbRRad8EjnHsY1w8xgCqb2_XJKtpO_SSIeIDuCvz1cv50TSGDjhSlhG536K';
        $devs=[];
        $devices = $reciever->device_token;
        foreach ($devices as $tokens) {
            if( is_array($tokens) ){
                foreach ($tokens as $token){
                    array_push($devs, $token);
                }
            }else{
                array_push($devs, $tokens);
            }
        }

        $data = [
            "registration_ids" =>$devs,
            "notification" => [
                "body" => $message,
                "title" => 'Private Me',
                "sound" => "notify.mp3",
                "tag" => "notification"
            ],
            "data" => [
                'screen' => $screen,
                'notification_data' => json_encode($notification_data),
                "body" => $message,
                "title" => 'Private Me',
                "type" => $type
            ]
        ];

        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        // FCM response
        return json_decode($result);
    }
}
