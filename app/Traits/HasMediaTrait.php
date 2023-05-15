<?php

namespace App\Traits;

use App\Services\ImageServices\ImageServices;
use Illuminate\Support\Str;
use App\Models\Media;

trait HasMediaTrait
{
    /**
     * Set the polymorphic relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'model');
    }

    /**
     * Add a file to the medialibrary.
     *
     * @param $file
     * @param $collection_name
     * @return bool
     */
    public function addMedia($file, $collection_name)
    {
        return app(ImageServices::class)->create($this, $file, $collection_name);
    }

    /**
     * Add a remote file to the medialibrary.
     *
     * @param string $url
     * @param $collection
     * @return bool
     *
     * @throws \Exception
     */
    public function addMediaFromUrl(string $url, $collection)
    {
        if (! $stream = @fopen($url, 'r')) {
            throw new \Exception('Unreachable Url '.$url);
        }

        $temporaryFile = tempnam(sys_get_temp_dir(), 'media-library');
        file_put_contents($temporaryFile, $stream);

        #$this->guardAgainstInvalidMimeType($temporaryFile, $allowedMimeTypes);

        $filename = basename(parse_url($url, PHP_URL_PATH));
        $filename = str_replace('%20', ' ', $filename);

        if ($filename === '') {
            $filename = 'file';
        }

        $mediaExtension = explode('/', mime_content_type($temporaryFile));

        if (! Str::contains($filename, '.')) {
            $filename = "{$filename}.{$mediaExtension[1]}";
        }

        $media = app(ImageServices::class)->createDbRecordOnly($this, $filename, $collection, $mediaExtension[0]);

        if( ! \File::exists(public_path("storage/$collection/$media->id-$media->file_name")) )
            \File::makeDirectory("public/storage/$collection", $mode = 0777, true, true);

        copy($temporaryFile, public_path("storage/$collection/$media->id-$media->file_name"));

        return true;
    }

    /*
     * Get the url of the image for the given conversionName
     * for first media for the given collectionName.
     * If no profile is given, return the source's url.
     */
    public function getFirstMediaUrl(string $collectionName = 'default', string $conversionName = '')
    {
        if( $media = $this->getFirstMedia($collectionName) )
            return $media->getUrl($conversionName);

        return false;
    }

    public function getFirstMedia(string $collectionName)
    {
        return $this->media->where('collection_name', $collectionName)->first();
    }

    /**
     * Remove all media in the given collection.
     *
     * @param string $collectionName
     *
     * @return HasMediaTrait|\Modules\Blog\Models\Blog
     */
    public function clearMediaCollection(string $collectionName = 'default'): self
    {
        $this->media->each(function ($item, $key) use ($collectionName) {

            if( \File::exists(public_path("storage/$collectionName/$item->id-$item->file_name")) ){

                \File::delete(public_path("storage/$collectionName/$item->id-$item->file_name"));
            }

            $item->delete();
        });

        return $this;
    }

    public function copyFrom($media, string $collectionName)
    {
        $url = $media->getFirstMediaUrl($collectionName);
        $this->addMediaFromUrl($url, $collectionName);

    }
}
