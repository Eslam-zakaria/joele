<?php

namespace Modules\InsuranceCompany\Repositories;

use App\Enums\GeneralEnums;
use Illuminate\Database\Eloquent\Model;
use Modules\InsuranceCompany\Models\InsuranceCompany;
use phpDocumentor\Reflection\Types\Collection;

class InsuranceCompanyRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * InsuranceCompanyRepository.
     *
     * @param InsuranceCompany $insuranceCompany
     */
    public function __construct(InsuranceCompany $insuranceCompany)
    {
        $this->model = $insuranceCompany;
    }

    /**
     * List model data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function list()
    {
        return $this->model
            ->inRandomOrder()
            ->orderBy('id', 'desc')
            ->where('status', 2)
            ->get();
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
            $model = $this->model->create($data);

            if (isset($data['image']))
                $model->addMedia($data['image'], 'insurance_company_image');

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

                $model->clearMediaCollection('insurance_company_image');

                $model->addMedia($data['image'], 'insurance_company_image');
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

            $model->clearMediaCollection('insurance_company_image');

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

            $new_model = $model->replicateWithTranslations();
            $new_model->created_at = now();
            $new_model->status = 1;
            $new_model->translate('ar')->title = $new_model->translate('ar')->title . ' copy';
            $new_model->translate('en')->title = $new_model->translate('en')->title . ' copy';
            $new_model->save();

        } catch (\Exception $e) {

            return false;
        }

        return true;
    }
}
