<?php

namespace Modules\Slider\Models;

use Illuminate\Database\Eloquent\Model;

class SliderTranslation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_title',
        'second_title',
        'description'
    ];
}
