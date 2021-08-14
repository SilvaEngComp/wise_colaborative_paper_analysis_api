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
    public function index(User $receiver, User $sender)
    {
        if ($receiver && $sender) {
            $messages = Chat::where(
                function ($query) use ($receiver, $sender) {
                    $query->where([
                        'sender' => $sender->id,
                        'receiver' => $receiver->id
                    ]);
                }
            )
                ->orWhere(
                    function ($query) use ($receiver, $sender) {
                        $query->where([
                            'receiver' => $sender->id,
                            'sender' => $receiver->id
                        ]);
                    }
                )->orderBy('created_at', 'ASC')->get();

            $chats = array();
            foreach ($messages as $chat) {
                array_push($chats, Chat::build($chat));
                $chat->receiver_read = 1;
                $chat->update();
            }
            return $chats;
        }

        return null;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function getUsers()
    {

        $receiver = Auth::user();
        $users = User::all()->where('id', '!=', $receiver->id);
        $chatUsers = array();
        foreach ($users as $sender) {
            $messages = Chat::where(['sender' => $sender->id, "receiver" => $receiver->id, "deleted" => 0])->get();
            $chatConfig = ChatConfigController::index($receiver, $sender);

            if (!$chatConfig) {
                $chatConfig = ChatConfigController::create($receiver, $sender);
            }
            $notRead = 0;
            foreach ($messages as $msg) {
                if ($msg->receiver_read == 0) {
                    $notRead++;
                }
            }
            array_push($chatUsers, array(
                "user" => [
                    "id" => $sender->id,
                    "name" => $sender->name,
                    "image" => $sender->image,
                ],
                "notRead" => $notRead,
                "chatConfig" => $chatConfig,
                "lastMessage" => end($messages),
            ));
        }
        return $chatUsers;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $receiver = User::find($request->input('receiver.id'));
        $sender = User::find($request->input('sender.id'));
        if ($receiver) {
            Chat::create([
                "sender" => $request->input('sender.id'),
                "receiver" => $request->input('receiver.id'),
                "message" => $request->input('message'),
                "date" => $request->input('date'),
            ]);

            $push = new Request([
                "title" => "Você receveu uma mensagem",
                "body" => $sender->name . ": " . $request->input('message'),
                "icon" => "",
                "click_action" => "3"
            ]);


            PushNotificationController::sendChat($push, $sender, $receiver);
            return $this->index($receiver, $sender);
        }

        return response(["message" => "usuário não está mais cadastrado"], 404);
    }


    public function destroy(Chat $chat, $op)
    {
        if ($op == 1) {
            $chat->delete();
        } else {
            $chat->deleted = 1;
        }

        $receiver = User::find($chat->receiver);
        $sender = User::find($chat->sender);

        $push = new Request();
        PushNotificationController::sendChat($push, $sender, $receiver, true);

        return $this->index($receiver, $sender);
    }
}
