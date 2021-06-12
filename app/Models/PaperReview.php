<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperReview extends Model
{
    use HasFactory;

    protected $fillable = [
        "paper_id",
        "review_id",
        "status",
    ];
}
