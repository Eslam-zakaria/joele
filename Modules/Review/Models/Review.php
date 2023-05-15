<?php

namespace Modules\Review\Models;

use App\Traits\StatusModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Branch\Models\Branch;
use Modules\Doctor\Models\Doctor;

class Review extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'status',
        'branch_id',
        'doctor_id',
        'message',
    ];

    /**
     * The attributes that are appended.
     *
     * @var array
     */
    protected $appends = ['statusData'];

    /**
     * Get status
     *
     * @return string[]
     */
    public function getStatusDataAttribute()
    {
        if( $this->status == 1 ){
            return [
                'class' => 'badge-success',
                'label' => 'Handled',
                'btn_class' => 'btn-success',
                'btn_icon' => 'fa fa-unlock'
            ];
        }else {
            return [
                'class' => 'badge-light',
                'label' => 'Pending',
                'btn_class' => 'btn-warning',
                'btn_icon' => 'fa fa-lock'
            ];
        }
    }

    /**
     * Service relation..
     *
     * @return BelongsTo
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Doctor relation.
     *
     * @return BelongsTo
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * review answer relation.
     *
     * @return HasMany
     */
    public function review_answer(): HasMany
    {
        return $this->hasMany(ReviewAnswer::class);
    }
}
