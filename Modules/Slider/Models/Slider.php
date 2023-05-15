<?php

namespace Modules\Slider\Models;

use App\Enums\GeneralEnums;
use App\Traits\StatusModelTrait;
use Eloquent;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Traits\HasMediaTrait;

class Slider extends Eloquent implements TranslatableContract
{
    use Translatable, StatusModelTrait, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['status'];

    /**
     * Appends attributes.
     *
     * @var string[]
     */
    protected $appends = [
        'title',
        'statusData',
        'slider_image',
        'slider_image_Thum'
    ];

    public $translatedAttributes = [
        'first_title',
        'second_title',
        'description'
    ];

    /**
     * Accessor to get first_title with second_title.
     *
     * @return string
     */
    public function getTitleAttribute(): string
    {
        return $this->first_title . ' ' . $this->second_title;
    }

    /**
     * Return slider image.
     *
     * @return string $imagePath
     */
    public function getSliderImageAttribute(): string
    {
        if( isset($this->media->first()->mime_type) && $this->media->first()->mime_type == 'video' )
            //return GeneralEnums::DEFAULT_Video_PLACEHOLDER;
            $this->getFirstMediaUrl('slider_image');

        if ($image = $this->getFirstMediaUrl('slider_image'))
            return $image;

        return asset('frontend/images/slider/slider-02.jpg');
    }

    /**
     * Return slider image.
     *
     * @return string $imagePath
     */
    public function getSliderImageThumAttribute(): string
    {
        if( isset($this->media->first()->mime_type) && $this->media->first()->mime_type == 'video' )
            return GeneralEnums::DEFAULT_Video_PLACEHOLDER;

        if ($image = $this->getFirstMediaUrl('slider_image'))
            return $image;

        return asset('frontend/images/slider/slider-02.jpg');
    }
}
