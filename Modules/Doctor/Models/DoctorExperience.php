<?php

namespace Modules\Doctor\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Eloquent;

class DoctorExperience extends Eloquent implements TranslatableContract
{
    use Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['doctor_id'];

    /**
     * Translated attributes.
     *
     * @var string[]
     */
    public $translatedAttributes = ['company_name', 'specialization'];
}
