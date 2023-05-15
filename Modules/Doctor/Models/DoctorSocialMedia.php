<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSocialMedia extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'instagram',
        'youtube',
        'facebook',
        'twitter',
        'snapchat',
        'whats_app',
        'email',
        'doctor_id',
    ];

    public $timestamps = false;
}
