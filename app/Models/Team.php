<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'teams';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id',
        'name',
        'slug',
        'profile_image',
        'type',
        'order_by',
        'designation_id',
        'experience',
        'facebook',
        'twitter',
        'instagram',
        'description',
        'speciality',

        'html_title',
        'meta_keyword',
        'meta_description',
    ];

    public function scopeSearchTeam($query, $name, $designation_id)
    {
        return $query->when($name, function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            ->when($designation_id, function ($query) use ($designation_id) {
                $query->where('designation_id', 'like', '%' . $designation_id . '%');
            });
    }


    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }
}
