<?php

namespace Modules\FrequentlyQuestion\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionCategoryTranslation extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
