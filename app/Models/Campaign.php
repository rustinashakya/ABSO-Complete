<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'campaigns';

    protected $fillable = [
        'status',
        'title',
        'url',
    ];

    public function images()
    {
        return $this->hasMany(CampaignImage::class);
    }

    public function languages()
    {
        return $this->belongsToMany(CampaignLanguage::class);
    }
}
