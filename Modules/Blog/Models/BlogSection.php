<?php

namespace Modules\Blog\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Eloquent;

class BlogSection extends Eloquent
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['blog_id','title','content','section_color','color_border','h_optionl', 'sorting'];

    /**
     * Appends attributes.
     *
     * @var string[]
     */
    protected $appends = [
        'section_slug'
    ];

    // /**
    //  * Translated attributes.
    //  *
    //  * @var string[]
    //  */
    // public $translatedAttributes = [
    //     'title',
    //     'content',
    // ];

    /**
     * @return string
     */
    public function getSectionSlugAttribute(): string
    {
        return str_replace(" ", "_", $this->title);
    }
}
