<?php

namespace App\Http\Controllers;

use App\Models\Protocol;
use App\Models\ProtocolType;
use App\Models\Review;
use Illuminate\Http\Request;

class ProtocolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Review $review)
    {

        $protocols = Protocol::where('review_id',$review->id)->get();
        $list = array();
        foreach($protocols as $p){
array_push($list, Protocol::build($p));
        }

        return $list;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store($protocol, Review $review)
    {
        if($review){
        Protocol::create([
            'review_id'=>$review->id,
        'protocol_type_id'=>$protocol['type']['id'],
        'question'=>$protocol['question'],
        'answer'=>$protocol['answer'],
        ]);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review, $type)
    {
        if($review){
        $protocols = Protocol::where('review_id',$review->id)
        ->where('prococol_type_id', $type)->get();

         $list = array();
        foreach($protocols as $p){
array_push($list, Protocol::build($p));
        }

        return $list;
        }

        return Response(['message'=>'Revisão não encontrada'],404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function edit(Protocol $protocol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Protocol $protocol)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function destroy(Protocol $protocol)
    {
        //
    }
}
