<?php

namespace Modules\Testimonial\Models;

use App\Traits\HasMediaTrait;
use App\Traits\StatusModelTrait;
use Eloquent;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Testimonial extends Eloquent  implements TranslatableContract
{
    use Translatable, StatusModelTrait, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['status', 'rating'];

    /**
     * Appends attributes.
     *
     * @var string[]
     */
    protected $appends = ['statusData'];

    /**
     * Translated attributes.
     *
     * @var string[]
     */
    public $translatedAttributes = ['name', 'description'];

    /**
     * Return testimonial image.
     *
     * @return string $imagePath
     */
    public function getTestimonialImageAttribute(): string
    {
        if ($image = $this->getFirstMediaUrl('testimonial_image'))
            return $image;

        return asset('frontend/images/avatar.jpg');
    }
}
