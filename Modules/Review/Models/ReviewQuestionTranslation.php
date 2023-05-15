<?php

namespace Modules\Review\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewQuestionTranslation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['question'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
