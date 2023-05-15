<?php

namespace Modules\Branch\Models;

use App\Traits\HasMediaTrait;
use App\Traits\StatusModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Category\Models\Category;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Modules\Doctor\Models\Doctor;
use Modules\Service\Models\Service;
use Modules\Offer\Models\Offer;

class Branch extends Eloquent  implements TranslatableContract
{
    use Translatable, StatusModelTrait, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
        'phone',
        'another_phone',
        'map_link',
        'status',
    ];

    /**
     * Appends attributes.
     *
     * @var string[]
     */
    protected $appends = [
        'statusData',
        'offer_image',
    ];

    /**
     * Translated attributes.
     *
     * @var string[]
     */
    public $translatedAttributes = ['name','slug'];

    /**
     * Return offer image.
     *
     * @return string $imagePath
     */
    public function getOfferImageAttribute(): string
    {
        if ($image = $this->getFirstMediaUrl('branch_offer_image'))
            return $image;

        return asset('frontend/images/offers/offer-01.jpg');
    }

    /**
     * Categories relation.
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Categories relation.
     *
     * @return BelongsToMany
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    /**
     * Offers relation.
     *
     * @return BelongsToMany
     */
    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class,'branch_offer', 'branch_id', 'offer_id');
    }

    /**
     * Doctors relation.
     *
     * @return belongsToMany
     */
    public function doctors(): belongsToMany
    {
        return $this->belongsToMany(Doctor::class);
    }

    /**
     * Doctors relation.
     *
     * @return belongsToMany
     */
    public function listDoctors(): belongsToMany
    {
        return $this->belongsToMany(Doctor::class)->where('status', 2)->with('translation');
    }

    /**
     * Get Services Ids.
     *
     * @return mixed
     */
    public function getServicesIdsAttribute()
    {
        return $this->services->lists('id');
    }

    /**
     * Get Categories Ids.
     *
     * @return mixed
     */
    public function getCategoriesIdsAttribute()
    {
        return $this->categories->lists('id');
    }
}
