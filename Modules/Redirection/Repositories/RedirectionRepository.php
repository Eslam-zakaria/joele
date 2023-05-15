<?php

namespace Modules\Redirection\Repositories;

use App\Enums\GeneralEnums;
use Illuminate\Database\Eloquent\Model;
use Modules\Redirection\Models\Redirection;
use phpDocumentor\Reflection\Types\Collection;

class RedirectionRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * ReviewsRepository.
     *
     * @param Redirection $review
     */
    public function __construct(Redirection $review)
    {
        $this->model = $review;
    }

    /**
     * List model.
     *
     * @param array $payload
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function list(array $payload = [])
    {
        $query = $this->model->query();

        if(isset($payload['q']) && $payload['q']) {

            $query->where('name', 'LIKE', '%' . $payload['q'] . '%')
                ->orWhere('phone', $payload['q']);

        }

        if( isset($payload['status']) && $payload['status'] )
            $query->where('status', $payload['status']);

        return $query->orderBy('id', 'desc')->get();
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

        if(isset($payload['q']) && $payload['q']) {

            $query->where('from', 'LIKE', '%' . $payload['q'] . '%')
                ->orWhere('to', 'LIKE', '%' . $payload['q'] . '%');

        }

        if( isset($payload['status']) && $payload['status'] )
            $query->where('status', $payload['status']);

        return $query->orderBy('id', 'desc')->paginate($perPage);
    }

    /**
     * List model.
     *
     * @return \Illuminate\Support\Collection
     */
    public function lastN(int $count = 6)
    {
        return $this->model
            ->inRandomOrder()
            ->where('status', 2)
            ->limit($count)
            ->with('doctor.media')
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
