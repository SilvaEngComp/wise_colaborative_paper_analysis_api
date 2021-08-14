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
}
