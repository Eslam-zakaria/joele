<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorExperienceTranslation extends Model
{
    protected $fillable = ['company_name', 'specialization'];
}
