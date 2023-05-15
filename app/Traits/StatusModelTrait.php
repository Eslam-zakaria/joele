<?php

namespace App\Traits;

use App\Constants\Statuses;

trait  StatusModelTrait
{
    /**
     * Get status
     *
     * @return string[]
     */
    public function getStatusDataAttribute()
    {
        if( $this->status == 1 )
            return [
                'class' => 'badge-light',
                'label' => 'Disabled',
                'btn_class' => 'btn-success',
                'btn_icon' => 'fa fa-unlock'
            ];

        return [
            'class' => 'badge-success',
            'label' => 'Active',
            'btn_class' => 'btn-warning',
            'btn_icon' => 'fa fa-lock'
        ];
    }
}
