<?php

namespace App\Services\ImageServices;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Storage;

class ImageServices
{
    protected $subject;

    /**
     * Add image
     *
     * @param Model $model
     * @param $file
     * @param $collection_name
     * @return bool
     */
    public function create(Model $model, $file, $collection_name): bool
    {
        try {

            $media = new Media();
            $media->name = pathinfo(str_replace(' ', '_', $file->getClientOriginalName()), PATHINFO_FILENAME);
            $media->file_name = str_replace(' ', '_', $file->getClientOriginalName());
            $media->disk = 'public';
            $media->collection_name = $collection_name;

            $model->media()->save($media);

            $file->move(public_path("storage/$media->collection_name"), "$media->id-$media->file_name");

        } catch (\Exception $e) {

            return false;
        }

        return true;
    }

    public function createDbRecordOnly(Model $model, $fileName, $collection_name, $file_type)
    {
        $media = new Media();
        $media->name = $fileName;
        $media->file_name = $fileName;
        $media->disk = 'public';
        $media->collection_name = $collection_name;
        $media->mime_type = $file_type;

        $model->media()->save($media);

        return $media;
    }
}
