<?php

namespace Modules\Redirection\Models;

use App\Traits\StatusModelTrait;
use Eloquent;

class Redirection extends Eloquent
{
    use StatusModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from',
        'to',
        'code',
        'status'
    ];

    /**
     * The attributes that are appended.
     *
     * @var array
     */
    protected $appends = ['statusData'];
}
