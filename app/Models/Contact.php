<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dateFormat = 'Y-m-d H:i';

    protected $table = 'contacts';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'email',
        'phone_no',
        'subject',
        'message',
        'address',
        'page_id'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
