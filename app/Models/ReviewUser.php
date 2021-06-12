<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewUser extends Model
{
    use HasFactory;

       protected $fillable = [
        "user_id",
        "review_id",
        "permission",
    ];
}
