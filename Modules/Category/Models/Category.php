<?php

namespace Modules\Category\Models;

use App\Enums\CategoriesRelationEnum;
use App\Traits\HasMediaTrait;
use App\Traits\StatusModelTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Branch\Models\Branch;
use Modules\Cases\Models\MedicalCase;
use Modules\Doctor\Models\Doctor;
use Modules\Lecture\Models\Lecture;
use Modules\Service\Models\Service;
use Modules\Specialization\Models\Specialization;

class Category extends Eloquent implements TranslatableContract
{
    use Translatable, StatusModelTrait, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'display_in',
        'service_items_per_row',
    ];

    /**
     * Appends attributes.
     *
     * @var string[]
     */
    protected $appends = [
        'category_image',
        'listDisplayIn',
        'statusData',
        'serviceItemsPerRowClass',

    ];

    /**
     * Translated attributes.
     *
     * @var string[]
     */
    public $translatedAttributes = [
        'name',
        'slug',
        'alt_image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical',
        'description'
    ];

    /**
     * Return category image.
     *
     * @return string $imagePath
     */
    public function getCategoryImageAttribute(): string
    {
        if ($image = $this->getFirstMediaUrl('category_image'))
            return $image;

        return asset('frontend/images/services/service-03.jpg');
    }

    /**
     * Set the display in.
     *
     * @param  string  $value
     * @return void
     */
    public function setDisplayInAttribute($value)
    {
        $this->attributes['display_in'] = json_encode($value);
    }

    /**
     * Get display in data.
     *
     * @return mixed
     */
    public function getDisplayInDataAttribute()
    {
        return json_decode($this->display_in, true);
    }

    /**
     * List display's in string.
     *
     * @return mixed
     */
    public function getListDisplayInAttribute()
    {
        return implode('-', json_decode($this->display_in, true));
    }

    /**
     * List service items per row class in string.
     *
     * @return mixed
     */
    public function getServiceItemsPerRowClassAttribute()
    {
        return CategoriesRelationEnum::GridOptions[$this->service_items_per_row]['class'] ?? 'col-md-4';
    }

    /**
     * Services relations.
     *
     * @return HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Branches relations.
     *
     * @return belongsToMany
     */
    public function branches(): belongsToMany
    {
        return $this->belongsToMany(Branch::class);
    }

    /**
     * Doctors relation.
     *
     * @return HasMany
     */
    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }

    /**
     * Lectures relation.
     *
     * @return HasMany
     */
    public function lectures(): HasMany
    {
        return $this->hasMany(Lecture::class);
    }

    /**
     * medical cases relation.
     *
     * @return HasMany
     */
    public function medicalCase(): HasMany
    {
        return $this->hasMany(MedicalCase::class);
    }

    /**
     * Specialization relations.
     *
     * @return HasMany
     */
    public function specialization(): HasMany
    {
        return $this->hasMany(Specialization::class);
    }
}
