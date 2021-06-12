<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewUser;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewUserController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Review $review)
    {
        return User::setArray($review->members);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store(Request $request, Review $review){
        $members = $request->input('members');

        foreach($members as $member){
ReviewUser::create([
            "user_id"=>$member['id'],
            "review_id"=>$review->id,
            "permission"=>1
        ]);
        }

    }



    /**
     * update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function update(Request $request, Review $review){
        $members = $request->input('members');

        ReviewUser::where('review_id',$review->id)->delete();
        foreach($members as $member){
ReviewUser::create([
            "user_id"=>$member['id'],
            "review_id"=>$review->id,
            "permission"=>$member['permission']
        ]);
        }

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReviewUser  $memberReview
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review, User $user)
    {
        if($review && $user){
            ReviewUser::where('user_id',$user->id)
            ->where('review_id', $review->id)->delete();

            return response(['message'=>'Membro deletado com sucesso!']);
        }

        return response(['message'=>'membro ou review não encontrado']);
    }
}
