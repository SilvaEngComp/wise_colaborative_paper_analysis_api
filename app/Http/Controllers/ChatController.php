<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        if ($user) {
            $userFrom = Auth::user();
            $userTo = $user;

            $messages = Chat::where(
                function ($query) use ($userTo, $userFrom) {
                    $query->where([
                        'from' => $userFrom,
                        'to' => $userTo
                    ]);
                }
            )
                ->orWhere(
                    function ($query) use ($userTo, $userFrom) {
                        $query->where([
                            'to' => $userFrom,
                            'from' => $userTo
                        ]);
                    }
                )->orderBy('created_at', 'ASC')->get();


                return $messages;
        }

        return null;
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
    public function store(Request $request, User $to)
    {
        if($to){
        Chat::create([
"from"=>Auth::user()->id,
"to"=>$to->id,
"message"=> $request->input('message')
        ]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
