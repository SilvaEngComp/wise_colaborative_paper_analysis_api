<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaReview extends Model
{
    use HasFactory;

    protected $fillable = [
        "review_id",
        "area_id"
    ];
}
