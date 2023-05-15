<?php

namespace Modules\Cases\Repositories;

use App\Enums\GeneralEnums;
use Illuminate\Database\Eloquent\Model;
use Modules\Cases\Models\MedicalCase;
use phpDocumentor\Reflection\Types\Collection;

class CasesRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * CasesRepository.
     *
     * @param MedicalCase $medicalCase
     */
    public function __construct(MedicalCase $medicalCase)
    {
        $this->model = $medicalCase;
    }

    /**
     * List model.
     *
     */
    public function list($payload = [], int $perPage = GeneralEnums::perPage)
    {
        $query = $this->model->query()->where('status', 2);

        if ( isset($payload['category']) )
            $query->where('category_id', $payload['category']);

        if ( isset($payload['branch']) )
            $query->where('branch_id', $payload['branch']);

        return $query->orderBy('id', 'desc')
            ->with('doctor.translation', 'category.translation', 'media')
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
            ->with('doctor.media', 'category.translation', 'media')
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

            if (isset($data['image_before']))
                $model->addMedia($data['image_before'], 'case_before_image');

            if (isset($data['image_after']))
                $model->addMedia($data['image_after'], 'case_after_image');

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

            if (isset($data['image_before'])) {

                $model->clearMediaCollection('case_before_image');

                $model->addMedia($data['image_before'], 'case_before_image');
            }

            if (isset($data['image_after'])) {

                $model->clearMediaCollection('case_after_image');

                $model->addMedia($data['image_after'], 'case_after_image');
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

            $model->clearMediaCollection('case_after_image');

            $model->clearMediaCollection('case_before_image');

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

            $new_model = $model->replicate();
            $new_model->created_at = now();
            $new_model->status = 1;
            $new_model->save();

        } catch (\Exception $e) {

            return false;
        }

        return true;
    }
}
