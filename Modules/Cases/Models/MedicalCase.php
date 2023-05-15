<?php

namespace Modules\Cases\Models;

use App\Enums\GeneralEnums;
use App\Traits\HasMediaTrait;
use App\Traits\StatusModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Branch\Models\Branch;
use Modules\Category\Models\Category;
use Modules\Doctor\Models\Doctor;

class MedicalCase extends Model
{
    use StatusModelTrait, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'doctor_id',
        'category_id',
        'branch_id',
    ];

    /**
     * Appends attributes.
     *
     * @var string[]
     */
    protected $appends = ['statusData', 'image_before', 'image_after'];

    /**
     * Doctor relation.
     *
     * @return BelongsTo
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class)->with('translation');
    }

    /**
     * Branch relation.
     *
     * @return BelongsTo
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class)->with('translation');
    }

    /**
     * Category relation.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Return case before image.
     *
     * @return string $imagePath
     */
    public function getImageBeforeAttribute(): string
    {
        if ($image = $this->getFirstMediaUrl('case_before_image'))
            return $image;

        return asset('frontend/images/before.jpg');
    }

    /**
     * Return case after image.
     *
     * @return string $imagePath
     */
    public function getImageAfterAttribute(): string
    {
        if ($image = $this->getFirstMediaUrl('case_after_image'))
            return $image;

        return asset('frontend/images/after.jpg');
    }
}
