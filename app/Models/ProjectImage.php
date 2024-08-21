<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectImage extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        // 'deleted_at'
    ];

    protected $fillable = [
        'project_id',
        'main_image',
        'mobile_image',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
