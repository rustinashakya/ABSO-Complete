<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectKpi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'project_id',
        'location',
        'altitude',
        'capacity',
        'cost',
        'funding_by',
        'source',
        'subbasin',
        'construction_begins',
        'end_date',
        'status',
        'kw_per_year',
        'full_load_hours',
        'plant_availability',
        'circulation_rate',
        'sector'
    ];


    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
