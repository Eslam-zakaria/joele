<?php

namespace Modules\FrequentlyQuestion\Models;

use App\Traits\StatusModelTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FrequentlyQuestion extends Model implements TranslatableContract
{
    use Translatable, StatusModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'status','where_show', 'language'];

    /**
     * Translated attributes.
     *
     * @var string[]
     */
    public $translatedAttributes = ['question', 'answer'];

    /**
     * Appends attributes.
     *
     * @var string[]
     */
    protected $appends = ['statusData', 'questionName'];

    /**
     * Category relation.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(QuestionCategory::class);
    }

    /**
     * Get question name.
     *
     * @return void
     */
    public function getQuestionNameAttribute()
    {
        return ( $this->translate('en') != null ) ?
            $this->translate('en')->question :
            $this->translate('ar')->question;
    }
}
