<?php

namespace Modules\Setting\Models;


use App\Constants\SettingTypes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Eloquent;

class Setting extends Eloquent  implements TranslatableContract
{
    use Translatable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'other_value',
        'translatable' # 1 => NO | 2 => YES
    ];

    public $translatedAttributes = ['value'];
}
