<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationUserController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
     * Display the specified resource.
     *
     * @param  \App\Models\NotificationUser  $notificationUser
     * @return \Illuminate\Http\Response
     */
    public function show(NotificationUser $notificationUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NotificationUser  $notificationUser
     * @return \Illuminate\Http\Response
     */
    public function edit(NotificationUser $notificationUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NotificationUser  $notificationUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotificationUser $notificationUser)
    {
        if($notificationUser){
            $notificationUser->has_saw = $request('has_saw');
            $notificationUser->update();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NotificationUser  $notificationUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationUser $notificationUser)
    {
        //
    }
}
