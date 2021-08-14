<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        "message",
        "file_path",
        "date",
        "sender",
        "receiver",
        "receiver_read",
        "deleted",
    ];


    public static function build(Chat $chat){

        $sender = User::find($chat->sender);
        $receiver = User::find($chat->receiver);

        return [
            "id"=>$chat->id,
            "message"=>$chat->message,
            "file_path"=>$chat->message,
            "sender"=>[
                "id"=>$sender->id,
                "name"=>$sender->name,
                "image"=>$sender->image,
            ], "receiver"=>[
                "id"=>$receiver->id,
                "name"=>$receiver->name,
                "image"=>$receiver->image,
            ],
            "date"=>$chat->date,
        ];
    }
}
