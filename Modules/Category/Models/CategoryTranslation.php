<?php

namespace Modules\Category\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'alt_image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical',
        'description'
    ];
}
