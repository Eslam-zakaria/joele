<?php

namespace Modules\FrequentlyQuestion\Models;

use App\Traits\HasMediaTrait;
use App\Traits\StatusModelTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class QuestionCategory extends Model implements TranslatableContract
{
    use Translatable, StatusModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['status', 'language'];

    /**
     * Translated attributes.
     *
     * @var string[]
     */
    public $translatedAttributes = ['name'];

    /**
     * Appends attributes.
     *
     * @var string[]
     */
    protected $appends = ['statusData', 'categoryName'];

    /**
     * Get question name.
     *
     * @return void
     */
    public function getCategoryNameAttribute()
    {
        return ( $this->translate('en') != null ) ?
            $this->translate('en')->name :
            $this->translate('ar')->name;
    }
}
