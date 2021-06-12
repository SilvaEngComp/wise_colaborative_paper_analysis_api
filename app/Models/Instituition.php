<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instituition extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "abreviation",
        "regions",
        "state"
    ];
}
