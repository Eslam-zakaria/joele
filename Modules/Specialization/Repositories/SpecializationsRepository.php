<?php

namespace Modules\Specialization\Repositories;

use App\Enums\GeneralEnums;
use Illuminate\Database\Eloquent\Model;
use Modules\Specialization\Models\Specialization;
use phpDocumentor\Reflection\Types\Collection;

class SpecializationsRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * SlidersRepository.
     *
     * @param Specialization $specialization
     */
    public function __construct(Specialization $specialization)
    {
        $this->model = $specialization;
    }

    /**
     * List model.
     *
     */
    public function list(array $payLoad = [])
    {
        $query = $this->model->query();

         if( isset($payLoad['category']) && $payLoad['category'])
             $query->where('category_id', $payLoad['category']);

        return $query->where('status', 2)->orderBy('id', 'desc')->with('translation')->get();
    }

    /**
     * List data of Model Tags.
     * @return Collection
     */
    public function getBypluck()
    {
        return $this->model->where('status', 2)->listsTranslations('name')->pluck('name','id');
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
