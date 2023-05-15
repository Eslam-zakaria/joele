<?php

namespace Modules\Service\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTranslation extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'new_slug',
        'description',
        'content',
        'alt_image',
        'meta_title',
        'canonical',
        'meta_description',
        'meta_keywords',
    ];
}
