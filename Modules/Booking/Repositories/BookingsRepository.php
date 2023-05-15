<?php

namespace Modules\Booking\Repositories;

use App\Enums\GeneralEnums;
use Illuminate\Database\Eloquent\Model;
use Modules\Booking\Controllers\Api\BookingController;
use Modules\Booking\Models\Booking;
use phpDocumentor\Reflection\Types\Collection;

class BookingsRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * CasesRepository.
     *
     * @param Booking $booking
     */
    public function __construct(Booking $booking)
    {
        $this->model = $booking;
    }

    /**
     * List model.
     *
     * @param array $payLoad
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function list(array $payLoad = [])
    {
        $query = $this->model->query();

        if( isset($payLoad['q']) && $payLoad['q'] ){
            $query->where('name', 'LIKE', '%' . $payLoad['q'] . '%')
                ->orWhere('phone', $payLoad['q']);
        }

        if( isset($payLoad['reference_id']) && $payLoad['reference_id'] )
            $query->where('order_reference', $payLoad['reference_id']);

        if( isset($payLoad['from']) && $payLoad['from'] )
            $query->whereDate('attendance_date', '>=', $payLoad['from']);

        if( isset($payLoad['to']) && $payLoad['to'] )
            $query->whereDate('attendance_date', '<=', $payLoad['to']);

        if( isset($payLoad['status']) && $payLoad['status'] )
            $query->where('status', $payLoad['status']);

        if( isset($payLoad['type']) && $payLoad['type'] )
            $query->where('type', $payLoad['type']);

        if( isset($payLoad['doctor']) && $payLoad['doctor'] )
            $query->where('doctor_id', $payLoad['doctor']);

        if( isset($payLoad['branch']) && $payLoad['branch'] )
            $query->where('branch_id', $payLoad['branch']);

        return $query->orderBy('id', 'desc')
            ->with('doctor', 'branch', 'offer')
            ->get();
    }

    /**
     * Get model.
     *
     * @param array $payLoad
     * @param int|null $type
     * @param int $perPage
     * @used-by BookingController::index()
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    public function get(array $payLoad = [], int $type = null, int $perPage = GeneralEnums::perPage)
    {
        $query = $this->model->query();

        if( isset($payLoad['q']) && $payLoad['q'] ){
            $query->where('name', 'LIKE', '%' . $payLoad['q'] . '%')
                ->orWhere('phone', $payLoad['q'])->orWhere('email', 'LIKE', '%' . $payLoad['q'] . '%');
        }

        if( isset($payLoad['reference_id']) && $payLoad['reference_id'] )
            $query->where('order_reference', $payLoad['reference_id']);

        if( isset($payLoad['from']) && $payLoad['from'] )
            $query->whereDate('attendance_date', '>=', $payLoad['from']);

        if( isset($payLoad['to']) && $payLoad['to'] )
            $query->whereDate('attendance_date', '<=', $payLoad['to']);

        if( isset($payLoad['status']) && $payLoad['status'] )
            $query->where('status', $payLoad['status']);

        if( isset($payLoad['type']) && $payLoad['type'] )
            $query->where('type', $payLoad['type']);

        if( isset($payLoad['doctor']) && $payLoad['doctor'] )
            $query->where('doctor_id', $payLoad['doctor']);

        if( isset($payLoad['branch']) && $payLoad['branch'] )
            $query->where('branch_id', $payLoad['branch']);

        return $query->orderBy('id', 'desc')
            ->with('doctor', 'branch', 'offer')
            ->paginate($perPage);
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
     * @return false|Model|Booking
     */
    public function create(array $data)
    {
        try {

            # save model.
            $model = $this->model->create($data);

        } catch (\Exception $e){

            return false;
        }

        return $model;
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
