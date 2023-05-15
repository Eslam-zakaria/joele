<?php

namespace Modules\Comment\Models;

use App\Traits\StatusModelTrait;
use Eloquent;
use Modules\Blog\Models\Blog;
use Modules\Comment\Constants\CommentStatus;

class Comment extends Eloquent
{
    use StatusModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'blog_id',
        'name',
        'phone',
        'comment',
        'status'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    protected $appends =[
        'statusLabel',
        'statusData',
    ];

    public function getStatusLabelAttribute()
    {
        return CommentStatus::getLabel($this->status);
    }
}
