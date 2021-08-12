<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\ReviewUser;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationUserController extends Controller
{

    public  static function store(Notification $notification, User $user, $invitation=false)
    {
        NotificationUser::create([
            'user_id'=>$user->id,
            'notification_id'=>$notification->id,
            'has_saw'=> false,
            'invitation'=> $invitation=false,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NotificationUser  $notificationUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotificationUser $notificationUser, User $user)
    {
        if($notificationUser){
            if($request->has('has_saw')){
            $notificationUser->has_saw = $request->input('has_saw');
            }

            if($request->has('invitation')){
                if(!$request->input('invitation')){
                    $this->destroy($notificationUser, $user);
                }else{
                    $review_user = ReviewUser::where('review_id',$request->review_id)->where('user_id',$user->id)->first();
                    if($review_user){
                        $review_user->accepted = 1;
                        $review_user->update();
                        $notificationUser->has_saw = $request->input('has_saw');
                    }else{
                        $notificationUser->has_saw = 0;
                    }
                }
            }
            $notificationUser->update();

            return NotificationController::index($user);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationUser $notificationUser, User $user)
    {
        $notification = Notification::find($notificationUser->notification_id);
        if($notification){
            $notification->delete();
            return NotificationController::index($user);
        }
    }
}
