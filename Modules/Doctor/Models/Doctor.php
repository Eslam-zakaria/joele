<?php

namespace Modules\Doctor\Models;

use App\Traits\HasMediaTrait;
use App\Traits\StatusModelTrait;
use Eloquent;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Branch\Models\Branch;
use Modules\Category\Models\Category;
use Modules\Review\Models\Review;
use Modules\Service\Models\Service;
use Modules\Cases\Models\MedicalCase;
use Modules\Specialization\Models\Specialization;


class Doctor extends Eloquent implements TranslatableContract
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
        'title_header_option',
        'language',
        'specialization_title_header_option'
    ];

    /**
     * Translated attributes.
     *
     * @var string[]
     */
    public $translatedAttributes = [
        'name',
        'slug',
        'experience_years',
        'new_slug',
        'description',
        'canonical',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'alt_image',
    ];

    /**
     * Appends attributes.
     *
     * @var string[]
     */
    protected $appends = [
        'doctor_image',
        'statusData',
        'doctorName'
    ];

    /**
     * Return doctor image.
     *
     * @return string $imagePath
     */
    public function getDoctorImageAttribute(): string
    {
        if ($image = $this->getFirstMediaUrl('doctor_image'))
            return $image;

        return asset('frontend/images/doctors/doctor-01.jpg');
    }

    /**
     * Branches relation.
     *
     * @return belongsToMany
     */
    public function branches(): belongsToMany
    {
        return $this->belongsToMany(Branch::class);
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
     * Services relations.
     *
     * @return BelongsToMany
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    /**
     * Medical cases relations.
     *
     * @return HasMany
     */
    public function medicalCase(): HasMany
    {
        return $this->hasMany(MedicalCase::class);
    }

    /**
     * Social media relation.
     *
     * @return HasOne
     */
    public function socialMedia(): HasOne
    {
        return $this->hasOne(DoctorSocialMedia::class);
    }

    /**
     * Doctor experience relation.
     *
     * @return HasMany
     */
    public function experience(): HasMany
    {
        return $this->hasMany(DoctorExperience::class);
    }

    /**
     * Doctor working days relation.
     *
     * @return HasMany
     */
    public function workingDays(): HasMany
    {
        return $this->hasMany(DoctorWorkingDay::class);
    }

    /**
     * Doctor reviews relation.
     *
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('status', 2);
    }

    /**
     * Get doctor social media.
     *
     * @return mixed
     */
    public function getSocialMediaDataAttribute()
    {
        if(!$this->socialMedia)
            return[];

        $data = $this->socialMedia->getAttributes();

        unset($data['id'], $data['doctor_id']);

        return $data;
    }

    /**
     * Specializations relation.
     *
     * @return belongsToMany
     */
    public function specializations(): belongsToMany
    {
        return $this->belongsToMany(Specialization::class, 'doctor_specialization', 'doctor_id', 'specialization_id');
    }

    /**
     * Get doctor name.
     *
     * @return void
     */
    public function getDoctorNameAttribute()
    {
        return ( $this->translate('en') != null ) ?
            $this->translate('en')->name :
            $this->translate('ar')->name;
    }
}
