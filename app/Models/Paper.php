<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Paper extends Model
{
    use HasFactory;

    protected $fillable = [
        'base_id',
        'title',
        'authors',
        'publication_title',
        'publication_year',
        'volume',
        'start_page',
        'end_page',
        'abstract',
        'issn',
        'isbn',
        'doi',
        'link',
        'keywords',
        'search_terms',
    ];

    public static function build(Paper $paper, Review $review){
$paperReview = PaperReview::where('paper_id',$paper->id)
->where('review_id',$review->id)->first();
if($paperReview){

return [
    'base_id'=>$paper->base_id,
        'title'=>$paper->title,
        'authors'=>$paper->authors,
        'publication_title'=>$paper->publication_title,
        'publication_year'=>$paper->publication_year,
        'volume'=>$paper->volume,
        'start_page'=>$paper->start_page,
        'end_page'=>$paper->end_page,
        'abstract'=>$paper->abstract,
        'issn'=>$paper->issn,
        'isbn'=>$paper->isbn,
        'doi'=>$paper->doi,
        'link'=>$paper->link,
        'keywords'=>$paper->keywords,
        'search_terms'=>$paperReview->search_terms,
        'status'=>$paperReview->status,
         "observation"=>$paperReview->observation,
        "issue"=>$paperReview->issue,
        "relevance"=>$paperReview->relevance,
        "paper_review"=>$paperReview->id,
];
}
    }


    public static function paperReview(Review $review)
    {
        return Paper::join('paper_reviews', 'paper_reviews.paper_id', '=', 'papers.id')
            ->where('paper_reviews.review_id', $review->id)->get();
    }

    public static function inputPaper(Base $base, $inst)
    {

        if ($base) {
            if ($base->id == 1) {
                $check  = false;
                if ($inst[13] != '') {
                    $check = self::check($inst[13],2);
                } else {
                    $check = self::check($inst[15]);
                }
                if ($check) {
                    return  Paper::create([
                        'base_id' => $base->id,
                        'title' => $inst[0],
                        'authors' => $inst[1],
                        'publication_title' => $inst[3],
                        'publication_year' => $inst[5],
                        'volume' => $inst[6],
                        'start_page' => $inst[8],
                        'end_page' => $inst[9],
                        'abstract' => $inst[10],
                        'issn' => $inst[11],
                        'isbn' => $inst[12],
                        'doi' => $inst[13],
                        'link' => $inst[15],
                        'keywords' => $inst[16],
                    ]);
                }
            }else if($base->id == 2){
                 $check  = false;
                if ($inst[5] != '') {
                    $check = self::check($inst[5],2);
                } else {
                    $check = self::check($inst[8]);
                }
                if ($check) {
                    return  Paper::create([
                        'base_id' => $base->id,
                        'title' => $inst[0],
                        'authors' => $inst[6],
                        'publication_title' => $inst[1],
                        'publication_year' => $inst[7],
                        'volume' => $inst[3],
                        'doi' => $inst[5],
                        'link' => $inst[8],
                    ]);
                }
            }
        }
    }

    public static function check($value, $op = 1)
    {
        if ($op == 1) {
            $paper = Paper::where('link', $value)->first();
        } else {
            $paper = Paper::where('doi', $value)->first();
        }

        if ($paper) {
            return false;
        }

        return true;
    }

    public static function filter(Request $request)
    {
        $user = Auth::user();
        $query = Paper::join('paper_reviews', 'paper_reviews.paper_id', '=', 'papers.id');

        if ($request->has('review_id')) {
            $query = $query->where('paper_reviews.review_id', $request->input('review_id'));
        }

        if ($request->has('base_id')) {
            $query = $query->where('papers.base_id', $request->input('base_id'));
        }


        return $query->get();
    }
}
