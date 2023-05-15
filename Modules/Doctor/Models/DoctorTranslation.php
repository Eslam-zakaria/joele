<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorTranslation extends Model
{
    protected $fillable = [
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
        'doctor_id',
    ];
}
