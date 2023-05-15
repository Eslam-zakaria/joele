<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    const TYPE_OTHER = 'other';

    protected $guarded = [];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /*
     * Get the url to a original media file.
     */
    public function getUrl(string $conversionName = ''): string
    {
        return  url('storage/'.$this->collection_name.'/'.$this->id.'-'.$this->file_name);
    }
    
}
