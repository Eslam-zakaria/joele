<?php

namespace App\Repositories;

use App\Enums\GeneralEnums;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Blog\Models\Blog;
use phpDocumentor\Reflection\Types\Collection;

class UsersRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * UsersRepository.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Get model.
     *
     * @param int $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    public function get(array $payload = [], int $perPage = GeneralEnums::perPage)
    {
        $query = $this->model->query();

        if( isset($payload['q']) && $payload['q'] )
            $query->where('name', 'LIKE', '%' . $payload['q'] . '%');

        if( isset($payload['status']) && $payload['status'] != 0 )
            $query->where('status', $payload['status']);

        return $query->orderBy('id', 'desc')->paginate($perPage);
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
