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
        'cited_by',
        'publisher',
        'type',
        'languages',
    ];


   public static function calcRelationship(Review $review, Paper $paper){

        $list = explode(',', strtolower($review->include_criteria));
        $list = array_unique($list);

        $cont = 0;
        $weight = count($list);
        for ($i=0; $i<count($list);$i++) {
            if (strlen($list[$i]) > 0) {
                $cont += $weight*substr_count(strtolower($paper->abstract), $list[$i]);
                $weight--;
            }
            if($i==1 && $cont==0){
                break;
            }
        }

        return $cont;
    }
    public static function build(Paper $paper, Review $review)
    {
        $paperReview = PaperReview::where('paper_id', $paper->id)
            ->where('review_id', $review->id)->first();
        if ($paperReview) {
            $relationship_level = 0;
            if($review->include_criteria){
            $relationship_level = self::calcRelationship($review, $paper);
            if($paperReview->relationship_level<=0){
              $paperReview->relationship_level =  $relationship_level;
              $paperReview->update();
            }
        }
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
                'id' => $paper->id,
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
                'type' => $paper->type,
                'link' => $paper->link,
                'keywords' => $paper->keywords,
                'search_terms' => $paperReview->search_terms,
                'status' => $paperReview->status,
                "observation" => $paperReview->observation,
                "issue" => $paperReview->issue,
                "relevanceText" => $relevance,
                "relevance" => $paperReview->relevance,
                "paper_review" => $paperReview->id,
                "star" => $paperReview->star,
                "goals" => $paperReview->goals,
                "main_contribuition" => $paperReview->main_contribuition,
                "approach" => $paperReview->approach,
                "techinique" => $paperReview->techinique,
                "hypothesis" => $paperReview->hypothesis,
                "evaluation_metrics" => $paperReview->evaluation_metrics,
                "features" => $paperReview->features,
                "codelink" => $paperReview->codelink,
                "relevance" => $paperReview->relevance,
                "research_methodology" => $paperReview->research_methodology,
                "future_work" => $paperReview->future_work,
                "open_works" => $paperReview->open_works,
                "baselines" => $paperReview->baselines,
                "datasets" => $paperReview->datasets,
                "languages" => $paperReview->languages,
                "relationship_level" => $relationship_level,
                "updated_at" =>$paperReview->updated_at,
            ];
        }
    }


    public static function paperReview(Review $review, $discarted=false)
    {
        if($discarted){
             return Paper::join('paper_reviews', 'paper_reviews.paper_id', '=', 'papers.id')
           ->where('paper_reviews.review_id', $review->id)
            ->where('paper_reviews.discarded', 1)->get();
        }
        return Paper::join('paper_reviews', 'paper_reviews.paper_id', '=', 'papers.id')
            ->where('paper_reviews.review_id', $review->id)
            ->where('paper_reviews.discarded', 0)->get();
    }

    public static function inputPaper(Base $base, $inst, $headers, $review)
    {
        if ($base) {
                    $title = null;
                    $authors = null;
                    $publication_title = null;
                    $publication_year = null;
                    $volume = null;
                    $startpage = null;
                    $endpage = null;
                    $abstract = null;
                    $issn = null;
                    $isbn = null;
                    $doi = null;
                    $link = null;
                    $keywords = null;
                    $language = null;
                    $type = 'Article';
                    $publisher = null;
                    $cited_by = null;


            foreach($headers as $header){
                if(array_key_exists('title', $header)){
                    $title = $inst[$header['title']];

                }
                 if(array_key_exists('authors', $header)){
                    $authors = $inst[$header['authors']];
                }
                 if(array_key_exists('publication_title', $header)){
                    $publication_title = $inst[$header['publication_title']];
                }
                 if(array_key_exists('year', $header)){
                    $publication_year = $inst[$header['year']];
                }
                 if(array_key_exists('volume', $header)){
                    $volume = $inst[$header['volume']];
                }
                 if(array_key_exists('startpage', $header)){
                    $startpage = $inst[$header['startpage']];
                }
                 if(array_key_exists('endpage', $header)){
                    $endpage =$inst[$header['endpage']];
                }
                 if(array_key_exists('abstract', $header)){
                    $abstract = $inst[$header['abstract']];
                }
                  if(array_key_exists('issn', $header)){
                    $issn = $inst[$header['issn']];
                }
                 if(array_key_exists('isbn', $header)){
                    $isbn = $inst[$header['isbn']];
                }
                 if(array_key_exists('doi', $header)){
                    $doi = $inst[$header['doi']];
                }
                 if(array_key_exists('link', $header)){
                    $link = $inst[$header['link']];
                }
                 if(array_key_exists('keywords', $header)){
                    $keywords = $inst[$header['keywords']];
                }
                if(array_key_exists('type', $header)){
                    $type = $inst[$header['type']];
                }
                if(array_key_exists('cited_by', $header)){
                    $cited_by = $inst[$header['cited_by']];
                }
                if(array_key_exists('language', $header)){
                    $language = $inst[$header['language']];
                }
                if(array_key_exists('publisher', $header)){
                    $publisher = $inst[$header['publisher']];
                }
                if(array_key_exists('cited_by', $header)){
                    $cited_by = $inst[$header['cited_by']];
                }

            }

               $check = self::check([$doi,$link, $authors, $title]);

               if($check){
                   $check->type = $type;
                //    echo "\n".$check->type;
                   $check->update();
                   return $check;
               }
                else {
                   return Paper::create(
                        [
                        'base_id' => $base->id,
                        'title' => $title,
                        'authors' => $authors,
                        'publication_title' => $publication_title,
                        'publication_year' => $publication_year,
                        'volume' => $volume,
                        'start_page' => $startpage,
                        'end_page' => $endpage,
                        'abstract' => $abstract,
                        'issn' => $issn,
                        'isbn' => $isbn,
                        'doi' => $doi,
                        'link' => $link,
                        'keywords' => $keywords,
                        'cited_by' => $cited_by,
                        'publisher' => $publisher,
                        'type' => $type,
                        'languages' => $language,

                        ]
                );


                }
        }
    }

    public static function check($values)
    {
        if ($values[0]!== null) {
            $paper = Paper::where('doi', $values[0])->first();
        } else{
            $paper = Paper::where('title', $values[1])
                ->where('authors', $values[2])
                ->first();
            if (!$paper) {
                $paper = Paper::where('link', $values[3])->first();
            }
        }
      return $paper;
    }

    public static function filter(Request $request)
    {
        $query = Paper::join('paper_reviews', 'paper_reviews.paper_id', '=', 'papers.id');

        if ($request->has('review_id')) {
            $query = $query->where('paper_reviews.review_id', $request->input('review_id'));
        }

        if ($request->has('base_id')) {
            if($request->input('base_id')>0){
            $query = $query->where('papers.base_id', $request->input('base_id'));
        }
        }

        if ($request->has('discarded')) {
            $query = $query->where('paper_reviews.discarded', $request->input('discarded'));
        }

         if ($request->has('analysed')) {
            $query = $query->where('paper_reviews.relevance','>',0);
        }

        if ($request->has('status')) {
            $query = $query->orderBy('paper_reviews.status', 'desc');
        }

        $query = $query->orderBy('paper_reviews.relevance','desc');


        $query->select("papers.id",
        "base_id",
        "title",
        "authors",
        "publication_title",
        "publication_year",
        "volume",
        "start_page",
        "end_page",
        "abstract",
        "issn",
        "isbn",
        "doi",
        "type",
        "link",
        "keywords",
        "cited_by",
        "review_id",
        "status",
        "observation",
        "issue",
        "relevance",
        "search_terms",
        "techinique",
        "approach",
        "features",
        "goals",
        "hypothesis",
        "main_contribuition",
        "evaluation_metrics",
        "baselines",
        "datasets",
        "codelink",
        "research_methodology",
        "algorithm_complexity",
        "future_work",
        "languages",
        "star",
        "discarded",
        "paper_reviews.updated_at",
    );


        return $query->get();
    }
}
