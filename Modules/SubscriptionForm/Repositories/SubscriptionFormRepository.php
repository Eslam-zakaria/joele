<?php

namespace Modules\SubscriptionForm\Repositories;

use App\Enums\GeneralEnums;
use Illuminate\Database\Eloquent\Model;
use Modules\SubscriptionForm\Models\SubscriptionForm;
use phpDocumentor\Reflection\Types\Collection;

class SubscriptionFormRepository
{
    protected $model;

    /**
     * ContactUsRepository.
     *
     * @param SubscriptionForm $subscriptionForm
     */
    public function __construct(SubscriptionForm $subscriptionForm)
    {
        $this->model = $subscriptionForm;
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

        if( $payload['q'] && $payload['q'] )
            $query->where('phone', $payload['q']);

        if( isset($payload['from']) && $payload['from'] )
            $query->whereDate('created_at', '>=', $payload['from']);

        if( isset($payload['to']) && $payload['to'] )
            $query->whereDate('created_at', '<=', $payload['to']);

        return $query->orderBy('id', 'desc')->get();
    }

    /**
     * Get model.
     *
     * @param array $payload
     * @param int $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    public function get(array $payload = [], int $perPage = GeneralEnums::perPage)
    {
        $query = $this->model->query();

        if( $payload['q'] && $payload['q'] )
            $query->where('phone', $payload['q']);

        if( isset($payload['from']) && $payload['from'] )
            $query->whereDate('created_at', '>=', $payload['from']);

        if( isset($payload['to']) && $payload['to'] )
            $query->whereDate('created_at', '<=', $payload['to']);

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
