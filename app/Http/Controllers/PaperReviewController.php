<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\Paper;
use App\Models\PaperReview;
use App\Models\Review;
use Illuminate\Http\Request;

class PaperReviewController extends Controller
{


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaperReview  $paperReview
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Base $base, Review $review)
    {
        $papers = PaperReview::join('papers','paper_reviews.paper_id','=','papers.id')
        ->where('papers.base_id',$base->id)
        ->where('paper_reviews.review_id',$review->id)
        ->get();
        foreach($papers as $paperReview){
                $paperReview->search_terms = $request->input('search_terms');
                $paperReview->update();
        }

        return Response(['message'=>'Termos de pesquisa atualizados'],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaperReview  $paperReview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaperReview $paperReview)
    {
        if($paperReview){
            if($paperReview){
            if($request->has('relevance')){
                $paperReview->relevance = $request->input('relevance');
            }
            if($request->has('status')){
                $paperReview->status = $request->input('status');
            }
            if($request->has('issue')){
                $paperReview->issue = $request->input('issue');
            }
            if($request->has('observation')){
                $paperReview->observation = $request->input('observation');
            }
            if($request->has('star')){
                $paperReview->star = $request->input('star');
            }
            if($request->has('lenguages')){
                $paperReview->lenguages = $request->input('lenguages');
            }
             if($request->has('techinique')){
                $paperReview->techinique = $request->input('techinique');
            }
              if($request->has('approach')){
                $paperReview->approach = $request->input('approach');
            }  if($request->has('features')){
                $paperReview->features = $request->input('features');
            }if($request->has('goals')){
                $paperReview->goals = $request->input('goals');
            }if($request->has('hypothesis')){
                $paperReview->hypothesis = $request->input('hypothesis');
            }if($request->has('research_methodology')){
                $paperReview->research_methodology = $request->input('research_methodology');
            }if($request->has('algorithm_comolexity')){
                $paperReview->algorithm_comolexity = $request->input('algorithm_comolexity');
            }if($request->has('future_work')){
                $paperReview->future_work = $request->input('future_work');
            }if($request->has('main_contribuition')){
                $paperReview->main_contribuition = $request->input('main_contribuition');
            }if($request->has('datasets')){
                $paperReview->datasets = $request->input('datasets');
            }if($request->has('baselines')){
                $paperReview->baselines = $request->input('baselines');
            }if($request->has('evaluation_metrics')){
                $paperReview->evaluation_metrics = $request->input('evaluation_metrics');
            }if($request->has('codelink')){
                $paperReview->codelink = $request->input('codelink');
            }

$paper = Paper::find($paperReview->paper_id);
            $paperReview->update();
            $request = new Request(['review_id' => $paperReview->review_id, "base_id"=>$paper->base_id]);


        return PaperController::show($request);

        }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaperReview  $paperReview
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaperReview $paperReview)
    {
        if($paperReview){
            $paperReview->discarted = 1;
            $paperReview->update();
        }
    }
}
