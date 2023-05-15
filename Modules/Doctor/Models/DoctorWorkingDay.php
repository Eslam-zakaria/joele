<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class DoctorWorkingDay extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'month',
        'branch_id',
        'doctor_id',
    ];

    public $timestamps = false;

    protected $appends = [
        'schedule'
    ];
    public function getScheduleAttribute()
    {
        $lang = app()->getLocale() == 'en' ? 'en' : 'ar';
        Carbon::setLocale($lang);
        return Carbon::parse($this->date)->translatedFormat('D, d M, Y');
    }
}
