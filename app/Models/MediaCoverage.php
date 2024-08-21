<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaCoverage extends Model
{
    use HasFactory;
    protected $table = 'media_coverages';

    protected $fillable = [
        'title',
        'publish_date',
        'file_image',
        'description',
        'meta_description',
        'meta_keyword',
        'slug'
    ];
}
