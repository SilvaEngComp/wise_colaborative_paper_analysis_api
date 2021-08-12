<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
       if($user){
           if($request->has('fcm_web_key')){
                $user->fcm_web_key  = $request->input('fcm_web_key');
           }

           if($request->has('fcm_mobile_key')){
                $user->fcm_mobile_key  = $request->input('fcm_mobile_key');
           }

           $user->update();
           return User::buildSimple($user);
       }

       return response(['message'=>'usuário não encontrado'],404);
    }

    public function send(Request $request){
         $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = 'AAAAaDn8EH0:APA91bFagtHGaRI-E5x0WjNnc79lwMHdAgtHLX05i8H5bzo6WFZjbEGuoGqQqEAPtk44FS3YiwxYBi8grqhDKG8IZYt7FyZ7sWngApviHGVGfBSmP7i8C9yx9T-htj1KDEcKKJLPXdVU';

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
          $notification = [
                "title" => $request->title,
                "body" => $request->body,
                "icon" => $request->icon,
                "click_action" => $request->click_action,
                "data"=>[
                "info"=>"This is a special informationfor the app"
            ]
        ];
         $resp = array();
        array_push($resp, $this->sendWebNotification($url, $headers, $notification));
        array_push($resp,$this->sendMobileNotification($url, $headers, $notification));

        return $resp;
    }


     public function sendMobileNotification($url, $headers, $notification)
    {
         $FcmToken = User::whereNotNull('fcm_mobile_key')->pluck('fcm_mobile_key')
        ->all();

if($FcmToken){
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => $notification
        ];
        $encodedData = json_encode($data);

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
        return $result;
    }
    }

    public function sendWebNotification($url, $headers, $notification)
    {
        $FcmToken = User::whereNotNull('fcm_web_key')->pluck('fcm_web_key')->all();
if($FcmToken){
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => $notification
        ];
        $encodedData = json_encode($data);

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
        return $result;
    }
    }


}
