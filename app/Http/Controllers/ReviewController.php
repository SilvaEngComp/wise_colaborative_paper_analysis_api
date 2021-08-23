<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        if($user){
         $reviews = User::reviews($user);
        $list = array();
        foreach($reviews as $review){
        array_push($list, Review::build($review));
        }


        return $list;
    }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $review = Review::create([
            "title"=>$request->input('title'),
            "question"=>$request->input('question'),
            "description"=>$request->input('description'),
        ]);

        ReviewAreaController::store($request,$review);
        ReviewUserController::store($request, $review);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        if($review){
            return Review::build($review);
        }

        return Response(['message'=>'Projeto não enctontrado'],404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        if($review){
        if($request->has('title')){
            $review->title = $request->input('title');
        }
        if($request->has('question')){
            $review->title = $request->input('title');
        }
        if($request->has('description')){
            $review->title = $request->input('title');
        }

        $review->update();

        if($request->has('includeCriteria')){
            foreach($request->input('includeCriteria') as $criteria){
                if(array_key_exists('answare', $criteria)){
            ProtocolController::store($criteria, $review);

                }
            }
        }
        if($request->has('excludeCriteria')){
            foreach($request->input('includeCriteria') as $criteria){
             if(array_key_exists('answare', $criteria)){
            ProtocolController::store($criteria, $review);

                }
            }
        }

        if($request->has('areas')){
            ReviewAreaController::update($request, $review);
        }

        if($request->has('members')){
            ReviewUserController::update($request, $review);
        }
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review, User $user)
    {
       if($review){
        //    $review->delete();
           return $this->index($user);
       }
    }
}
