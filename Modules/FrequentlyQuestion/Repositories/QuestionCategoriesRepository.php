<?php

namespace Modules\FrequentlyQuestion\Repositories;

use App\Enums\GeneralEnums;
use Illuminate\Database\Eloquent\Model;
use Modules\FrequentlyQuestion\Models\QuestionCategory;
use phpDocumentor\Reflection\Types\Collection;

class QuestionCategoriesRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * QuestionCategoriesRepository.
     *
     * @param QuestionCategory $questionCategory
     */
    public function __construct(QuestionCategory $questionCategory)
    {
        $this->model = $questionCategory;
    }

    /**
     * List model data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function list()
    {
        return $this->model
            ->orderBy('id', 'desc')
            ->where('status', 2)
            ->get();
    }

    /**
     * Get model.
     *
     * @param array $querySearch
     * @param int $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    public function get(array $querySearch = [], int $perPage = GeneralEnums::perPage)
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
