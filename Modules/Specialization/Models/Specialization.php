<?php

namespace Modules\Specialization\Models;

use App\Traits\StatusModelTrait;
use Eloquent;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Traits\HasMediaTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Category\Models\Category;

class Specialization extends Eloquent implements TranslatableContract
{
    use Translatable, StatusModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['status','category_id'];

    public $translatedAttributes = ['name'];

    /**
     * Appends attributes.
     *
     * @var string[]
     */
    protected $appends = ['statusData'];

    /**
     * Category relation.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->with('translations');
    }
}
