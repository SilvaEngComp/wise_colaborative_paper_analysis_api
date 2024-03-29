<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Review;
use App\Models\ReviewArea;
use Illuminate\Http\Request;

class ReviewAreaController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store(Request $request, Review $review)
    {
        $areas = $request->input('areas');
        foreach ($areas as $area) {
            ReviewArea::create([
                "area_id" => $area['id'],
                "review_id" => $review->id
            ]);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function update(Request $request, Review $review)
    {
        ReviewArea::where('review_id', $review->id)->delete();

        $areas = $request->input('areas');
        foreach ($areas as $area) {
            ReviewArea::create([
                "area_id" => $area['id'],
                "review_id" => $review->id
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReviewArea  $areaReview
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review, Area $area)
    {
        if ($review && $area) {
            ReviewArea::where('area_id', $area->id)
                ->where('review_id', $review->id)->delete();

            return response(['message' => 'Área deletada com sucesso!']);
        }

        return response(['message' => 'Área ou projeto não encontrado']);
    }
}
