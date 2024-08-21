<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlideImage extends Model
{
    use HasFactory;

    protected $table = 'slide_images';

    protected $fillable = [
        'id',
        'name',
        'caption_description',
        'slider_type',
        'main_image',
        'mobile_image',
        'youtube_url',
        'url',
    ];
}
