<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public static function send(Request $request,  $users=null){
         $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = 'AAAAaDn8EH0:APA91bFagtHGaRI-E5x0WjNnc79lwMHdAgtHLX05i8H5bzo6WFZjbEGuoGqQqEAPtk44FS3YiwxYBi8grqhDKG8IZYt7FyZ7sWngApviHGVGfBSmP7i8C9yx9T-htj1KDEcKKJLPXdVU';

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
          $notification = [
                "title" => $request->title,
                "body" => $request->body,
                "icon" =>Auth::user(),
                "click_action" => $request->click_action,

        ];
         $resp = array();
        array_push($resp, self::sendWebNotification($url, $headers, $notification));
        // array_push($resp,self::sendMobileNotification($url, $headers, $notification));

        return $resp;
    }
    public static function sendChat(Request $request,  User $sender, User $receiver){
         $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = 'AAAAaDn8EH0:APA91bFagtHGaRI-E5x0WjNnc79lwMHdAgtHLX05i8H5bzo6WFZjbEGuoGqQqEAPtk44FS3YiwxYBi8grqhDKG8IZYt7FyZ7sWngApviHGVGfBSmP7i8C9yx9T-htj1KDEcKKJLPXdVU';

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
          $notification = [
                "title" => $request->title,
                "body" => $request->body,
                "icon" => $sender,
                "click_action" => $request->click_action,

        ];
            $FcmToken = array();
               $token = User::where('id',$receiver->id)->select('fcm_web_key')->first();
         array_push($FcmToken, $token->fcm_web_key);
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




    public static function sendWebNotification($url, $headers, $notification)
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


     public static function sendMobileNotification($url, $headers, $notification)
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

}
