<?php

namespace Modules\ContactUs\Models;

use App\Enums\GeneralEnums;
use App\Traits\StatusModelTrait;
use Illuminate\Database\Eloquent\Model;


class ContactUs extends Model
{
    use StatusModelTrait;

    /**
     * Appends attributes.
     *
     * @var string[]
     */
    protected $appends = [
        'statusData',
        'topic'
    ];

    protected $fillable = [
        'name',
        'phone',
        'subject',
        'message',
        'notes',
        'status',
    ];

    /**
     * Get status
     *
     * @return string[]
     */
    public function getStatusDataAttribute()
    {
        if( $this->status == 1 ){
            return [
                'class' => 'badge-light',
                'label' => 'Handled',
                'btn_class' => 'btn-success',
                'btn_icon' => 'fa fa-unlock'
            ];
        }else {
            return [
                'class' => 'badge-success',
                'label' => 'Pending',
                'btn_class' => 'btn-warning',
                'btn_icon' => 'fa fa-lock'
            ];
        }
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getTopicAttribute()
    {
        return GeneralEnums::Contact_Us_Topic[$this->subject]['ar'] ?? '';
    }
}
