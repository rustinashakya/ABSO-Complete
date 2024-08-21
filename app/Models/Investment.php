<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Investment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'capital',
        'start_year',
        'payback_period',
        'roi',
        'page_id',
        'project_type_id',
        'stage',
        'short_description',
        'main_image',
        'mobile_image',
        'type_of_service',

        //meta
        'html_title',
        'meta_description',
        'meta_keyword',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function scopeSearchInvestment($query, $title, $slug, $stage, $project_type_id, $page_id)
    {
        return $query
            ->when($title, function ($query) use ($title) {
                return $query->where('title', 'like', '%' . $title . '%');
            })
            ->when($slug, function ($query) use ($slug) {
                return $query->where('slug', 'like', '%' . $slug . '%');
            })
            ->when($stage, function ($query) use ($stage) {
                return $query->where('stage', $stage);
            })
            ->when($page_id, function ($query) use ($page_id) {
                return $query->where('page_id', $page_id);
            })
            ->when($project_type_id, function ($query) use ($project_type_id) {
                return $query->where('project_type_id', $project_type_id);
            });
    }
}
