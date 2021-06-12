<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'question',
        'description',
    ];

    public function members(){
        return $this->belongsToMany(User::class);
    }
    public function areas(){
        return $this->belongsToMany(Area::class);
    }

    public static function build(Review $review){
        $members = User::setUserArray($review->members);

        return [
            "title"=>$review->title,
            "question"=>$review->question,
            "description"=>$review->description,
            "instituition"=>$review->title,
            "areas"=>$review->areas,
            "members"=>$members,
        ];
    }
}
