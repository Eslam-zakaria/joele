<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical',
        'slug',
        'new_slug',
        'alt_image',
    ];
}
