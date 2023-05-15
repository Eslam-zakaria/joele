<?php

namespace Modules\Lecture\Repositories;

use App\Enums\GeneralEnums;
use Illuminate\Database\Eloquent\Model;
use Modules\Lecture\Models\Lecture;
use phpDocumentor\Reflection\Types\Collection;

class LecturesRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * LecturesRepository.
     *
     * @param Lecture $lecture
     */
    public function __construct(Lecture $lecture)
    {
        $this->model = $lecture;
    }

    /**
     * List model.
     *
     * @param $payload
     * @param int $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function list($payload = [], int $perPage = GeneralEnums::perPage)
    {
        $query = $this->model->query()->where('status', 2);

        if ( isset($payload['category']) )
            $query->where('category_id', $payload['category']);

        return $query->orderBy('id', 'desc')
            ->with('translation', 'media', 'category.translation')
            ->paginate($perPage);
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
     * List model.
     *
     * @return \Illuminate\Support\Collection
     */
    public function lastN(int $count = 8)
    {
        return $this->model
//            ->orderBy('id', 'desc')
            ->inRandomOrder()
            ->where('status', 2)
            ->with('translation', 'category.translation', 'media')
            ->limit($count)
            ->get();
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
                $model->addMedia($data['image'], 'lecture_image');

        } catch (\Exception $e){

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

                $model->clearMediaCollection('lecture_image');

                $model->addMedia($data['image'], 'lecture_image');
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

            $model->clearMediaCollection('lecture_image');

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

            $new_lecture = $model->replicateWithTranslations();
            $new_lecture->created_at = now();
            $new_lecture->status = 1;
            $new_lecture->translate('ar')->title = $new_lecture->translate('ar')->title . ' copy';
            $new_lecture->translate('en')->title = $new_lecture->translate('en')->title . ' copy';
            $new_lecture->save();

        } catch (\Exception $e) {

            return false;
        }

        return true;
    }
}
