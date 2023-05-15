<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class BlogSectionTranslation extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable..
     *
     * @var string[]
     */
    public $fillable = [
        'title',
        'content',
        'section_color',
    ];
}
