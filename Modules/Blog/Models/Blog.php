<?php

namespace Modules\Blog\Models;

use App\Traits\HasMediaTrait;
use App\Traits\StatusModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Category\Models\Category;
use Modules\Comment\Models\Comment;
use Modules\Doctor\Models\Doctor;
use Modules\FrequentlyQuestion\Models\FrequentlyQuestion;

class Blog extends Model
{
    use StatusModelTrait, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'doctor_id',
        'parent_id',
        'status',
        'title',
        'slug',
        'description',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical',
        'new_slug',
        'alt_image',
        'locale',
        'title_header_optional'
    ];

    // /**
    //  * Translated attributes.
    //  *
    //  * @var string[]
    //  */
    // public $translatedAttributes = [

    // ];

    /**
     * Appends attributes.
     *
     * @var string[]
     */
    protected $appends = [
        'statusData',
        'blog_image',
    ];

    /**
     * Blog relation.
     *
     * @return BelongsTo
     */
    public function childs()
    {
    	return $this->hasMany(Blog::class, 'parent_id');
    }
    /**
     * Blog relation.
     *
     * @return BelongsTo
     */
    public function parent()
    {
    	return $this->belongsTo(Blog::class, 'parent_id');
    }
    /**
     * Doctor relation.
     *
     * @return BelongsTo
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class)->with('translations');
    }

    /**
     * Category relation.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->with('translations');
    }

    /**
     * Comments relation.
     *
     * @return BelongsTo
     */
    public function comments(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }

    /**
     * Sections relation.
     *
     * @return HasMany
     */
    public function sections(): HasMany
    {
        return $this->hasMany(BlogSection::class)->orderBy('sorting','asc');
    }

    /**
     * Faq relation.
     *
     * @return HasMany
     */
    public function faqs(): HasMany
    {
        return $this->hasMany(BlogFaq::class);
    }

    /**
     * Return blog image.
     *
     * @return string $imagePath
     */
    public function getBlogImageAttribute(): string
    {
        if ($image = $this->getFirstMediaUrl('blog_image'))
            return $image;

        return asset('web/images/blog/1.jpg');
    }

    /**
     * FaqPage relation.
     *
     * @return HasMany
     */
    public function faqPage()
    {
        return $this->belongsToMany(FrequentlyQuestion::class, 'faq_pages', 'blog_id', 'frequently_question_id');
    }
}
