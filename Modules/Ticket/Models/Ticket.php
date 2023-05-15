<?php

namespace Modules\Ticket\Models;


use Eloquent;
use Modules\Ticket\Constants\TicketPurpose;

class Ticket extends Eloquent
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'subject',
        'content',
        'topic',
        'purpose',
    ];

    /**
     * The attributes that are appended.
     *
     * @var array
     */
    protected $appends = [
        'purposeLabel'
    ];

    public function getPurposeLabelAttribute()
    {
       return TicketPurpose::getLabel($this->purpose);
    }
}
