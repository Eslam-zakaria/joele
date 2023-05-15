<?php

namespace Modules\Lecture\Models;

use Illuminate\Database\Eloquent\Model;

class LectureTranslation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title'];
}
