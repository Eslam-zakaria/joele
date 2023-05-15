<?php
namespace Modules\FrequentlyQuestion\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Eloquent;
use Modules\Blog\Models\Blog;
use Modules\Service\Models\Service;
use Modules\FrequentlyQuestion\Models\FrequentlyQuestion;
class FaqPage extends Eloquent
{

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
    'frequently_question_id',
    'service_id',
    'blog_id',
    ];

    /**
     * FrequentlyQuestion relation.
     *
     * @return BelongsTo
     */
    public function frequentlyQuestion()
    {
        return $this->belongsTo(FrequentlyQuestion::class, 'frequently_question_id');
    }

    /**
     * Service relation.
     *
     * @return BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Blog relation.
     *
     * @return BelongsTo
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }
}
