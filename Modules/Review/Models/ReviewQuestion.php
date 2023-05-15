<?php

namespace Modules\Review\Models;

use App\Traits\StatusModelTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Eloquent;

class ReviewQuestion extends Eloquent implements TranslatableContract
{
    use Translatable, StatusModelTrait;

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
        'statusData',
    ];

    /**
     * Translated attributes.
     *
     * @var string[]
     */
    public $translatedAttributes = ['question'];
}
