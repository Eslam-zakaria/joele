<?php

namespace Modules\Branch\Models;

use Illuminate\Database\Eloquent\Model;

class BranchTranslation extends Model
{
    protected $fillable = ['name', 'address', 'slug'];
}
