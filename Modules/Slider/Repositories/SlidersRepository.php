<?php

namespace Modules\Slider\Repositories;

use App\Enums\GeneralEnums;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Slider\Models\Slider;
use phpDocumentor\Reflection\Types\Collection;

class SlidersRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * SlidersRepository.
     *
     * @param Slider $slider
     */
    public function __construct(Slider $slider)
    {
        $this->model = $slider;
    }

    /**
     * List model.
     *
     */
    public function list()
    {
        return $this->model
            ->where('status', 2)
//            ->orderBy('id', 'desc')
            ->inRandomOrder()
            ->with('translation', 'media')
            ->get();
    }

    /**
     * Get model.
     *
     * @param int $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    public function get(int $perPage = GeneralEnums::perPage)
    {
        return $this->model->orderBy('id', 'desc')->paginate($perPage);
    }

    /**
     * Get specification model by key.
     *
     * @param int $key
     * @return Model
     */
    public function find(int $key): Model
    {
        return $this->model->where('id', $key)->first();
    }

    /**
     * Create new model.
     *
     * @param array $data
     *
     * @return bool
     */
    public function create(array $data): bool
    {
        try {

            # save model.
            $model = $this->model->create($data);

            if (isset($data['image']))
                $model->addMedia($data['image'], 'slider_image');

            if (isset($data['link']) && is_string($data['link']) && Str::contains($data['link'], ['https://', 'http://']))
                $model->addMediaFromUrl($data['link'], 'slider_image');

        } catch (\Exception $e){
            throw $e;
            return false;
        }

        return true;
    }

    /**
     * Update model.
     *
     * @param Model $model
     * @param array $data
     *
     * @return bool
     */
    public function update(Model $model, array $data): bool
    {
        try {

            # update model.
            $model->update($data);

            if (isset($data['image'])) {

                $model->clearMediaCollection('slider_image');

                $model->addMedia($data['image'], 'slider_image');
            }

            if (isset($data['link']) && is_string($data['link']) && Str::contains($data['link'], ['https://', 'http://'])){

                $model->clearMediaCollection('slider_image');

                $model->addMediaFromUrl($data['link'], 'slider_image');
            }

        } catch (\Exception $e){

            return false;
        }

        return true;
    }

    /**
     * Delete model.
     *
     * @param Model $model
     *
     * @return bool
     */
    public function delete(Model $model): bool
    {
        try {

            $model->clearMediaCollection('slider_image');

            $model->delete();

        } catch (\Exception $e){

            return false;
        }

        return true;
    }

    /**
     * Replicate model.
     *
     * @param Model $model
     *
     * @return bool
     */
    public function replicate(Model $model): bool
    {
        try {

            $new_model = $model->replicateWithTranslations();
            $new_model->created_at = now();
            $new_model->status = 1;
            $new_model->translate('ar')->first_title = $new_model->translate('ar')->first_title . ' copy';
            $new_model->translate('en')->first_title = $new_model->translate('en')->first_title . ' copy';
            $new_model->translate('ar')->second_title = $new_model->translate('ar')->second_title . ' copy';
            $new_model->translate('en')->second_title = $new_model->translate('en')->second_title . ' copy';
            $new_model->save();

        } catch (\Exception $e) {

            return false;
        }

        return true;
    }
}
