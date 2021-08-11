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

    public static function build(Paper $paper, Review $review)
    {
        $paperReview = PaperReview::where('paper_id', $paper->id)
            ->where('review_id', $review->id)->first();
        if ($paperReview) {
            $relevance = null;
            if ($paperReview->relevance) {
                switch ($paperReview->relevance) {
                    case 1:
                        $relevance = 'baixa';
                        break;
                    case 2:
                        $relevance = 'média';
                        break;
                    case 3:
                        $relevance = 'alta';
                        break;
                }
            }

            return [
                'base_id' => $paper->base_id,
                'title' => $paper->title,
                'authors' => $paper->authors,
                'publication_title' => $paper->publication_title,
                'publication_year' => $paper->publication_year,
                'volume' => $paper->volume,
                'start_page' => $paper->start_page,
                'end_page' => $paper->end_page,
                'abstract' => $paper->abstract,
                'issn' => $paper->issn,
                'isbn' => $paper->isbn,
                'doi' => $paper->doi,
                'link' => $paper->link,
                'keywords' => $paper->keywords,
                'search_terms' => $paperReview->search_terms,
                'status' => $paperReview->status,
                "observation" => $paperReview->observation,
                "issue" => $paperReview->issue,
                "relevanceTex" => $relevance,
                "relevance" => $paperReview->relevance,
                "paper_review" => $paperReview->id,
                "star" => $paperReview->star,
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
                    $check = self::check($inst[13]);
                } else {
                    $check = self::check([$inst[15], $inst[1], $inst[0]], 2);
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
            } else if ($base->id == 2) {
                $check  = false;
                if ($inst[5] != '') {
                    $check = self::check($inst[5]);
                } else {
                    $check = self::check([$inst[8], $inst[6], $inst[0]], 2);
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
            } else if ($base->id == 3) {
                $check  = false;
                if ($inst[9] != '') {
                    $check = self::check($inst[9]);
                } else {
                    $check = self::check([$inst[10], $inst[0], $inst[1]], 2);
                }

                if ($check) {
                    return  Paper::create([
                        'base_id' => $base->id,
                        'title' => $inst[1],
                        'authors' => $inst[0],
                        'publication_year' => $inst[2],
                        'volume' => $inst[3],
                        'doi' => $inst[9],
                        'link' => $inst[10],
                        'start_page' => $inst[6],
                        'end_page' => $inst[7],
                        'abstract' => $inst[11],
                        'issn' => $inst[12],
                        'isbn' => $inst[13],
                    ]);
                }
            }
        }
    }

    public static function check($value, $op = 1)
    {

        if ($op == 1) {
            $paper = Paper::where('doi', $value)->first();
        } else if ($op == 2) {
            $paper = Paper::where('title', $value[2])
                ->where('authors', $value[1])
                ->first();
            if (!$paper) {
                $paper = Paper::where('link', $value[0])->first();
            }
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
        if ($request->has('status')) {
            $query = $query->orderBy('paper_reviews.status', 'desc');
        }

        if ($request->has('relevance')) {
            $query = $query->orderBy('paper_reviews.relevance', $request->input('relevance'));
        }


        return $query->get();
    }
}
