<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'google_map',
        'site_logo',
        'facebook',
        'linkedin',
        'meta_description',
        'phone_no',
        'email',
        'meta_keyword',
        'address',
        'postal_code',
        'site_favicon',
        'instagram',
        'youtube_link',
        'twitter',
        'title',
        'html_title',
        'description',
        'pinterest',
        'language_id',
        'site_description',

        //head office details
        'head_office_address',
        'head_office_phone_no',
        'head_office_email',
        'head_office_map',

        // team meta data
        'team_html_title',
        'team_meta_keyword',
        'team_meta_description',

        // project meta data
        'project_html_title',
        'project_meta_keyword',
        'project_meta_description',

        // investment meta data
        'investment_html_title',
        'investment_meta_keyword',
        'investment_meta_description',

        // news meta data
        'news_html_title',
        'news_meta_keyword',
        'news_meta_description',

        // client meta data
        'client_html_title',
        'client_meta_keyword',
        'client_meta_description',

        // legal document meta data
        'legal_document_html_title',
        'legal_document_meta_keyword',
        'legal_document_meta_description',

        // contact us meta data
        'contact_us_html_title',
        'contact_us_meta_keyword',
        'contact_us_meta_description',

        //career meta data
        'career_html_title',
        'career_meta_keyword',
        'career_meta_description',

        //history meta data
        'history_html_title',
        'history_meta_keyword',
        'history_meta_description',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
