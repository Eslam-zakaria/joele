<?php

namespace Modules\InsuranceCompany\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceCompanyTranslation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'content'];
}
