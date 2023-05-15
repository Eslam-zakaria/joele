<?php

namespace Modules\Doctor\Repositories;

use App\Enums\GeneralEnums;
use Illuminate\Database\Eloquent\Model;
use Modules\Doctor\Models\DoctorExperience;
use phpDocumentor\Reflection\Types\Collection;

class DoctorExperienceRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * DoctorExperienceRepository.
     *
     * @param DoctorExperience $doctorExperience
     */
    public function __construct(DoctorExperience $doctorExperience)
    {
        $this->model = $doctorExperience;
    }

    /**
     * List model.
     *
     * @return void
     */
    public function list()
    {
        //
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

            $model->clearMediaCollection('doctor_image');

            $model->delete();

        } catch (\Exception $e){

            return false;
        }

        return true;
    }
}
