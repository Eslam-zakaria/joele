<?php

namespace Modules\InsuranceCompany\Models;

use App\Constants\Statuses;
use App\Enums\GeneralEnums;
use App\Traits\HasMediaTrait;
use App\Traits\StatusModelTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Eloquent;

class InsuranceCompany extends Eloquent  implements TranslatableContract
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
    protected $appends = ['insurance_company_image', 'statusData'];

    /**
     * Translated attributes.
     *
     * @var string[]
     */
    public $translatedAttributes = ['title', 'content'];


    /**
     * Return insurance company image.
     *
     * @return string $imagePath
     */
    public function getInsuranceCompanyImageAttribute(): string
    {
        if ($image = $this->getFirstMediaUrl('insurance_company_image'))
            return $image;

        return asset('frontend/images/insurance/company-01.jpg');
    }
}
