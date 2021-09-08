<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\Paper;
use App\Models\PaperReview;
use App\Models\Review;
use Illuminate\Http\Request;


class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Review $review)
    {
        $papers =  Paper::paperReview($review);
        $list = array();
        foreach ($papers as $paper) {
            array_push($list, Paper::build($paper, $review));
        }

        return $list;
    }

    public static function show(Request $request)
    {
        $review = Review::find($request->input('review_id'));
         $papers =  Paper::filter($request);
        $list = array();
        foreach ($papers as $paper) {
            array_push($list, Paper::build($paper, $review));
        }

        return $list;
    }

    public function mainTerms(Review $review)
    {
        $papers =  Paper::paperReview($review);
        $listO = array();
        $listI = array();
        $strI = '';
        $strO = '';
        foreach ($papers as $paper) {
            array_push($listI, $paper->issue);
            $strI .= ' ' . $paper->issue;
            array_push($listO, $paper->observation);
            $strO .= ' ' . $paper->observation;
        }
        $listI = array_unique($listI);
        $listO = array_unique($listO);

        $contI = 0;
        $termI = '';
        foreach ($listI as $term) {
            if (strlen($term) > 0) {
                $tot = substr_count($strI, $term);
                if ($tot > $contI) {
                    $contI = $tot;
                    $termI = $term;
                }
            }
        }
        $contO = 0;
        $termO = '';
        foreach ($listI as $term) {
            if (strlen($term) > 0) {
                $tot = substr_count($strI, $term);
                if ($tot > $contO) {
                    $contO = $tot;
                    $termO = $term;
                }
            }
        }

        return Response(["issue" => ["term" => $termI, "ocorrencies" => $contI], "observation" => ["term" => $termO, "ocorrencies" => $contO]]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Base $base, Review $review)
    {

        $search_terms = $request->input('search_terms');
        $objects =  explode(',', preg_replace('/[\{\}\[\]\" "]+/', '', $request->input('headers')));
        $headers = array();

        $i = 0;
        for ($i = 0; $i < count($objects); $i += 2) {
            $elements1 = explode(':', $objects[$i]);
            $elements2 = explode(':', $objects[$i + 1]);
            array_push($headers, array(
                $elements1[1] => $elements2[1],
            ));
        }
        $file = $request->file('file');
        if ($file) {
            $path = $request->file('file')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            $csv_data = array_slice($data, 0, count($data));
            unset($csv_data[0]);
            foreach ($csv_data as $data) {
                $paper = Paper::inputPaper($base, $data, $headers, $review);
                if ($paper) {

                    $paperReview = PaperReview::where('paper_id', $paper->id)
                        ->where('review_id', $review->id)->first();
                    if (!$paperReview) {
                        PaperReview::create([
                            "paper_id" => $paper->id,
                            "review_id" => $review->id,
                            "search_terms" => $search_terms,
                        ]);
                    }
                }
            }
            return $this->index($review);
        }
        return response(["message" => "Nenhum arquivo selecionado"], 404);
    }



    public function destroy(Paper $paper)
    {
        if ($paper) {
            $paper->delete();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paper $paper)
    {
        if ($paper) {
        }
    }
}
