<?php

namespace Modules\Specialization\Models;

use Illuminate\Database\Eloquent\Model;

class SpecializationTranslation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'specialization_id'];

    public $timestamps = false;
}
