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

    public static function members(Review $review){
        return User::join('review_users','review_users.user_id','=','users.id')
        ->select('users.id','users.name','users.image','users.gender','users.active', 'review_users.accepted')
        ->where('review_users.review_id',$review->id)->get();
    }
    public static function areas(Review $review){
        return Area::join('review_areas','review_areas.area_id','=','areas.id')
        ->where('review_areas.review_id',$review->id)->get();
    }

    public static function build(Review $review){
        $members = User::setUserArray(self::members($review));

        return [
            "id"=>$review->id,
            "title"=>$review->title,
            "question"=>$review->question,
            "description"=>$review->description,
            "instituition"=>$review->title,
            "include_criteria"=>$review->include_criteria,
            "exclude_criteria"=>$review->exclude_criteria,
            "areas"=>self::areas($review),
            "members"=>$members,
        ];
    }
}
