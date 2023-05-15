<?php

namespace Modules\Booking\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mail;
use Modules\Branch\Models\Branch;
use Modules\Doctor\Models\Doctor;
use Modules\Offer\Models\Offer;

class Booking extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'offer_id',
        'doctor_id',
        'branch_id',
        'note',
        'attendance_date',
        'available_time',
        'order_reference',
        'payment_type',
        'type_installment',
        'type',
        'price',
        'status'
    ];

    /**
     * The attributes that are appended.
     *
     * @var array
     */
    protected $appends = [
        'statusData',
    ];

    /**
     * Get status
     *
     * @return string[]|void
     */
    public function getStatusDataAttribute()
    {
        switch ( $this->status ){
            case 1:
                return [
                    'class' => 'badge-light',
                    'label' => 'Pending',
                ];

            case 2:
                return [
                    'class' => 'badge-success',
                    'label' => 'Confirmed',
                ];

            case 3:
                return [
                    'class' => 'badge-warning',
                    'label' => 'No Answer',
                ];

            case 4:
                return [
                    'class' => 'badge-warning',
                    'label' => 'Canceled',
                ];

            case 5:
                return [
                    'class' => 'badge-danger',
                    'label' => 'Not Confirmed',
                ];
        }
    }

    /**
     * Get the post that owns the comment.
     *
     * @return BelongsTo
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Get the post that owns the comment.
     *
     * @return BelongsTo
     */
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * Get the post that owns the comment.
     *
     * @return BelongsTo
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
