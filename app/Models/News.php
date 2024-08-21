<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'news';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'title',
        'slug',
        'published_date',
        'main_image',
        'mobile_image',
        'youtube_link',
        'description',
        'html_title',
        'meta_description',
        'meta_keyword',
        'author',
    ];

    public function scopeSearchPage($query, $title, $slug, $to, $from)
    {
        return $query->when($title, function ($query) use ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        })
            ->when($slug, function ($query) use ($slug) {
                $query->where('slug', 'like', '%' . $slug . '%');
            })
            ->when($from && $to, function ($query) use ($from, $to) {
                $query->whereBetween('published_date', [$from, $to]);
            })
            ->when($from && !$to, function ($query) use ($from) {
                $query->where('published_date', '>=', $from);
            })
            ->when(!$from && $to, function ($query) use ($to) {
                $query->where('published_date', '<=', $to);
            });
    }
}
