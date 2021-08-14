<?php

namespace App\Http\Controllers;

use App\Models\ChatConfig;
use App\Models\User;
use Illuminate\Http\Request;

class ChatConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index(User $receiver, User $sender)
    {
        return ChatConfig::where(['sender'=> $sender->id,"receiver"=>$receiver->id])->first();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function create(User $receiver, User $sender)
    {
        return  ChatConfig::create([
            "sender"=>$sender->id,
            "receiver"=>$receiver->id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      return  ChatConfig::create([
            "audio"=>$request->input('audio'),
            "favorite"=>$request->input('favorite'),
            "sender"=>$request->input('sender'),
            "receiver"=>$request->input('receiver'),
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChatConfig  $chatConfig
     * @return \Illuminate\Http\Response
     */
    public function show(ChatConfig $chatConfig)
    {
        if($chatConfig){
            return $chatConfig;
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChatConfig  $chatConfig
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChatConfig $chatConfig)
    {
        if($chatConfig){

            if($request->has('audio')){
                $chatConfig->audio = $request->input('audio');
            }
            if($request->has('favorite')){
                $chatConfig->audio = $request->input('audio');
            }

            $chatConfig->update();

            return ChatController::getUsers();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChatConfig  $chatConfig
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatConfig $chatConfig)
    {
        //
    }
}
