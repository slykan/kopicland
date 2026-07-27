<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Article extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'excerpt', 'body', 'seo_title', 'seo_description'];

    protected $fillable = [
        'slug', 'title', 'excerpt', 'body', 'seo_title', 'seo_description',
        'image_path', 'photo_credit', 'photo_source_url', 'status', 'sort_order',
    ];
}
