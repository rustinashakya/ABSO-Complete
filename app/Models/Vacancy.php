<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'reports_to',
        'image',
        'vacancy_level_id',
        'description',
        'status',
        'deadline',
        'created_by',
        'type',

        //meta data
        'html_title',
        'meta_description',
        'meta_keyword',
    ];

    public function level()
    {
        return $this->belongsTo(VacancyLevel::class, 'vacancy_level_id');
    }
}
