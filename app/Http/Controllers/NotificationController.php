<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index(User $user)
    {
        if($user){
        return Notification::join('notification_users','notifications.id','=','notification_users.notification_id')
        ->select('notification_users.who_send','notifications.message','notifications.created_at','notification_users.invitation','notifications.review_id', 'notification_users.id','notification_users.has_saw')
        ->where('notification_users.user_id',$user->id)
        ->get();
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store($message, Review $review, User $user, $invitation=false)
    {
        if($review){
      $notification = Notification::create([
          'message'=>$message,
          "review_id"=>$review->id,
          ]);
        }else{
           $notification = Notification::create([
          'message'=>$message,
          ]);

        }

          NotificationUserController::store($notification, $user, $invitation);
    }

}
