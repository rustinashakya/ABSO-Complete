<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentLanguage extends Model
{
    use HasFactory;
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['investment_id', 'language_id', 'title', 'description'];


    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
