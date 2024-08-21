<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsLanguage extends Model
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
        'description',
        'news_id',
        'language_id'
    ];

    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
