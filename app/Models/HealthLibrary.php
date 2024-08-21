<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthLibrary extends Model
{
    use HasFactory;

    protected $table = 'health_libraries';

    protected $fillable = [
        'id',
        'link',
        'thumbnail'
    ];
}
