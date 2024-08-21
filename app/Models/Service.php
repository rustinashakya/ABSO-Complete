<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';

    protected $fillable = [
        'service_name',
        'service_image',
        'home_icon',
        'service_mobile_image',
        'service_description',
        'slug',
        'meta_keyword',
        'meta_description'
    ];
}
