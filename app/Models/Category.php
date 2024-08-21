<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'id',
        'name',
        'category_image',
        'category_parent_id',
        'is_menu'
    ];

    public function parentCategory() {
        return $this->belongsTo(Category::class,'category_parent_id','id');
    }

    public function pages() {
        return $this->hasMany(Page::class);
    }

    public function scopeAbout($query)
{
    return $query->where('id', '=', 1);
}

public function scopeResponsibility($query)
{
    return $query->where('id', '=', 2);

}

public function scopeTechnology($query)
{
    return $query->where('id', '=', 3);

}

public function scopeInvestors($query)
{
    return $query->where('id', '=', 4);

}

public function scopeContact($query)
{
    return $query->where('id', '=', 5);

}

}
