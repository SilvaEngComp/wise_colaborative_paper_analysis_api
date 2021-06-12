<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            'inspec_controlled_terms',
            'not_inspec_controlled_terms',
            'mesh_terms',
    ];
}
