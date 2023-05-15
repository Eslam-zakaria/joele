<?php

namespace Modules\Review\Repositories;

use App\Enums\GeneralEnums;
use Illuminate\Database\Eloquent\Model;
use Modules\Review\Models\ReviewQuestion;
use phpDocumentor\Reflection\Types\Collection;

class ReviewQuestionsRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * ReviewQuestionsRepository.
     *
     * @param ReviewQuestion $reviewQuestion
     */
    public function __construct(ReviewQuestion $reviewQuestion)
    {
        $this->model = $reviewQuestion;
    }

    /**
     * List model.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function list()
    {
        return $this->model
            ->where('status', 2)
            ->orderBy('id', 'desc')
            ->with('translations')
            ->paginate(10);
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
            $this->model->create($data);

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

            $model->delete();

        } catch (\Exception $e){

            return false;
        }

        return true;
    }
}
