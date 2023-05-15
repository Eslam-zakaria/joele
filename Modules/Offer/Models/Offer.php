<?php

namespace Modules\Offer\Models;


use App\Traits\HasMediaTrait;
use App\Traits\StatusModelTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Branch\Models\Branch;
use Modules\Category\Models\Category;

class Offer extends Eloquent  implements TranslatableContract
{
    use Translatable, StatusModelTrait, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['price', 'category_id', 'status'];

    public $translatedAttributes = ['name'];

    /**
     * Appends attributes.
     *
     * @var string[]
     */
    protected $appends = ['offer_image', 'statusData'];

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
     * Branches relation.
     *
     * @return BelongsToMany
     */
    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class,'branch_offer', 'offer_id', 'branch_id');
    }

    /**
     * Return offer image.
     *
     * @return string $imagePath
     */
    public function getOfferImageAttribute(): string
    {
        if ($image = $this->getFirstMediaUrl('offer_image'))
            return $image;

        return asset('frontend/images/offers/offer-02.jpg');
    }
}
