<?php

namespace Modules\Lecture\Models;

use App\Enums\GeneralEnums;
use App\Traits\HasMediaTrait;
use App\Traits\StatusModelTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Category\Models\Category;

class Lecture extends Eloquent  implements TranslatableContract
{
    use Translatable, StatusModelTrait, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'status',
        'link',
    ];

    /**
     * Translated attributes.
     *
     * @var string[]
     */
    public $translatedAttributes = ['title'];

    /**
     * Appends attributes.
     *
     * @var string[]
     */
    protected $appends = [
        'lecture_image',
        'statusData',
    ];

    /**
     * Category relation.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Return lecture image.
     *
     * @return string $imagePath
     */
    public function getLectureImageAttribute(): string
    {
        if ($image = $this->getFirstMediaUrl('lecture_image'))
            return $image;

        return asset('frontend/images/lecture.jpg');
    }
}
