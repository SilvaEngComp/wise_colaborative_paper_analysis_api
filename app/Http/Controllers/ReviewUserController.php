<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Review;
use App\Models\ReviewUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index(Review $review)
    {
       return Review::build($review);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store(Request $request, Review $review)
    {
        if ($review) {
            $members = $request->input('members');

            foreach ($members as $member) {
                if (!self::check($review->id, $member['id'])) {
                    ReviewUser::create([
                        "user_id" => $member['id'],
                        "review_id" => $review->id,
                        "accepted" => 0
                    ]);

                    $from = Auth::user();
                    $to = User::find($member['id']);
                    $message = "Olá ".$to->name.", Você foi convidadeo por ".$from->name." para participar da revisão sistemaática ".$review->name;

                    NotificationController::store($message, $review, $to, true);
                }
            }



            return self::index($review);
        }
    }

    public static function check($review_id, $user_id)
    {
        $user = ReviewUser::where('review_id', $review_id)->where('user_id', $user_id)->first();
        if ($user) {
            return true;
        }

        return false;
    }

    /**
     * update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function update(Request $request, Review $review)
    {
        $members = $request->input('members');

        ReviewUser::where('review_id', $review->id)->delete();
        foreach ($members as $member) {
            ReviewUser::create([
                "user_id" => $member['id'],
                "review_id" => $review->id,
                "accepted" => 0
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

        if ($review && $user) {
            ReviewUser::where('user_id', $user->id)
                ->where('review_id', $review->id)->delete();

                    $message = "Olá ".$user->name.", você se retirou oficialmente do projeto. Para ingressar novamente, entre em contato com um dos integrantes do projeto para lhe adicionar novamente";

                    NotificationController::store($message, $review, $user);
             return self::index($review);
        }

        return response(['message' => 'membro ou review não encontrado'], 404);
    }
}
