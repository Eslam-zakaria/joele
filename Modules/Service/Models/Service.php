<?php

namespace Modules\Service\Models;


use App\Enums\GeneralEnums;
use App\Traits\HasMediaTrait;
use App\Traits\StatusModelTrait;
use Eloquent;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Modules\Category\Models\Category;
use Modules\FrequentlyQuestion\Models\FrequentlyQuestion;
use Modules\FrequentlyQuestion\Models\FaqPage;

class Service extends Eloquent  implements TranslatableContract
{
    use Translatable, StatusModelTrait, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['status', 'category_id', 'title_header_option', 'language'];

    /**
     * Translated attributes.
     *
     * @var string[]
     */
    public $translatedAttributes = [
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

    /**
     * Appends attributes.
     *
     * @var string[]
     */
    protected $appends = ['statusData', 'service_image', 'serviceName'];

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
     * Return service image.
     *
     * @return string $imagePath
     */
    public function getServiceImageAttribute(): string
    {
        if ($image = $this->getFirstMediaUrl('service_image'))
            return $image;

        return asset('frontend/images/services/service-03.jpg');
    }

    /**
     * FaqPage relation.
     *
     * @return BelongsToMany
     */
    public function faqPage(): belongsToMany
    {
        return $this->belongsToMany(FrequentlyQuestion::class, 'faq_pages', 'service_id', 'frequently_question_id');
    }

    /**
     * Get service name.
     *
     * @return void
     */
    public function getServiceNameAttribute()
    {
        return ( $this->translate('en') != null ) ?
            $this->translate('en')->name :
            $this->translate('ar')->name;
    }
}
