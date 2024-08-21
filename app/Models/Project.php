<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at', 
        'deleted_at'
    ];

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'project_type_id',
        'page_id',
        'service_id',
        'stage',
        'show_on_menu', // show on frontend menu or not 
        'show', //show on list page or not

        //meta data
        'html_title',
        'meta_description',
        'meta_keyword',
    ];

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function service()
    {
        return $this->belongsTo(Page::class, 'service_id');
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class, 'project_id');
    }

    public function projectKpis()
    {
        return $this->hasOne(ProjectKpi::class, 'project_id');
    }

    public function scopeSearchProject($query, $title, $slug, $project_type_id, $page_id, $stage)
    {
        return $query
            ->when($title, function ($query) use ($title) {
                return $query->where('title', 'like', '%' . $title . '%');
            })
            ->when($slug, function ($query) use ($slug) {
                return $query->where('slug', 'like', '%' . $slug . '%');
            })
            ->when($project_type_id, function ($query) use ($project_type_id) {
                return $query->where('project_type_id', $project_type_id);
            })
            ->when($page_id, function ($query) use ($page_id) {
                return $query->where('page_id', $page_id);
            })
            ->when($stage, function ($query) use ($stage) {
                return $query->where('stage', $stage);
            });
    }
}
