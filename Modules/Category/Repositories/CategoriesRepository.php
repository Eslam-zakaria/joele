<?php

namespace Modules\Category\Repositories;

use App\Enums\GeneralEnums;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Models\Category;
use phpDocumentor\Reflection\Types\Collection;

class CategoriesRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * CategoriesRepository.
     *
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /**
     * List model.
     *
     * @param string|null $model
     * @param array $relations
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection|Category[]
     */
    public function all(string $model = null, array $relations = [])
    {
        return $this->model
            ->where('status', 2)
//            ->orderBy('id', 'desc')
            ->inRandomOrder()
            ->with('translation', 'media')
            ->get();
    }

    /**
     * List model.
     *
     * @param string|null $model
     * @param array $relations
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection|Category[]
     */
    public function list(string $model = null,array $relations = [])
    {
        return $this->model
            ->where('status', 2)
            ->whereJsonContains('display_in', $model)
            ->orderBy('id', 'desc')
            ->with($relations)
            ->get();
    }

    /**
     * Get specification model by slug.
     *
     * @param string $slug
     * @return Model
     */
    public function categoriesPage(string $slug)
    {
        return $this->model
                    ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                    ->select('category_translations.*', 'categories.id', 'categories.status', 'categories.service_items_per_row')
                    ->where('category_translations.slug',$slug)
                    ->where('categories.status', 2)
                    ->with('translation')->first();
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
     * Get specification active model.
     *
     * @param int $key
     * @param string $model
     *
     * @return Model
     */
    public function find_active(int $key, string $model):? Model
    {
        return $this->model
            ->whereJsonContains('display_in', $model)
            ->where('id', $key)
            ->where('status', 2)
            ->first();
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
                $model->addMedia($data['image'], 'category_image');

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

                $model->clearMediaCollection('category_image');

                $model->addMedia($data['image'], 'category_image');
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

            $model->clearMediaCollection('category_image');

            $model->delete();

        } catch (\Exception $e){

            return false;
        }

        return true;
    }
}
