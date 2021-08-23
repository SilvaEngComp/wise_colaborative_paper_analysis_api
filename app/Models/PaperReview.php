<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperReview extends Model
{
    use HasFactory;

    protected $fillable = [
        "paper_id",
        "review_id",
        "status",
        "observation",
        "issue",
        "goals",
        "main_contribuition",
        "approach",
        "techinique",
        "hypothesis",
        "evaluation_metrics",
        "features",
        "codelink",
        "relevance",
        "research_methodology",
        "future_work",
        "baselines",
        "datasets",
        "languages",
        "star",
        "discarted",
    ];
}
