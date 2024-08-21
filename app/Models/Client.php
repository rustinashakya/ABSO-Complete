<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
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
        'slug',
        'description',
        'url',
        'profile_image',
        'organisation_logo',
        'designation',
        //meta data
        'html_title',
        'meta_description',
        'meta_keyword',
    ];

    public function scopeSearchClient($query, $name, $slug, $designation)
    {
        return $query
            ->when($name, function ($query) use ($name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($slug, function ($query) use ($slug) {
                return $query->where('slug', 'like', '%' . $slug . '%');
            })
            ->when($designation, function ($query) use ($designation) {
                return $query->where('designation', 'like', '%' . $designation . '%');
            });
    }
}
