<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pages';

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'id',
        'name',
        'slug',
        'parent_id',
        'sub_title',
        'description',
        'main_image',
        'mobile_image',
        'icon',
        'youtube_link',
        'type',
        'category_id',
        'html_title',
        'meta_description',
        'meta_keyword',
        'order_by',
    ];

    public function scopeSearchPage($query, $title, $slug=null)
    {
        return $query->when($title, function ($query) use ($title) {
            $query->where('name', 'like', '%' . $title . '%');
        })
            ->when($slug, function ($query) use ($slug) {
                $query->where('slug', 'like', '%' . $slug . '%');
            });
    }

    public function pageLanguages()
    {
        return $this->hasMany(LanguagePage::class, 'page_id', 'id');
    }

    public function serviceAccordions()
    {
        return $this->hasMany(ServiceAccordion::class, 'page_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id', 'id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'page_id', 'id');
    }
}
