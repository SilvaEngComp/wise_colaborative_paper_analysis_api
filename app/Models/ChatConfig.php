<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        "audio",
        "favorite",
        "sender",
        "receiver",
    ];

    public static function build(ChatConfig $config, User $receiver, User $sender){
        return [
            "id"=>$config->id,
            "audio"=>$config->audio,
            "favorite"=>$config->favorite,
            "receiver"=>[
                "id"=>$receiver->id,
                "name"=>$receiver->name,
                "image"=>$receiver->image,
            ],
            "sender"=>[
                "id"=>$sender->id,
                "name"=>$sender->name,
                "image"=>$sender->image,
            ]
        ];
    }
}
