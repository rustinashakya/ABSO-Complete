<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'type',
        'phone',
        'address',
        'cv_file',
        'vacancy_id',
        'high_level_education',
        'training_description',
        'cover_letter',
        'salary_expectation',
        'experience',
        'stage',
    ];

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class, 'vacancy_id');
    }

    public function scopeSearchApplicant($query, $name, $email, $phone, $vacancy_id)
    {
        return $query
            ->when($name, function ($query) use ($name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($email, function ($query) use ($email) {
                return $query->where('email', 'like', '%' . $email . '%');
            })
            ->when($phone, function ($query) use ($phone) {
                return $query->where('phone', 'like', '%' . $phone . '%');
            })
            ->when($vacancy_id, function ($query) use ($vacancy_id) {
                return $query->where('vacancy_id', $vacancy_id);
            });
    }
}
