<?php

namespace Modules\Testimonial\Repositories;

use App\Enums\GeneralEnums;
use Illuminate\Database\Eloquent\Model;
use Modules\Testimonial\Models\Testimonial;
use phpDocumentor\Reflection\Types\Collection;

class TestimonialsRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * TestimonialsRepository.
     *
     * @param Testimonial $model
     */
    public function __construct(Testimonial $model)
    {
        $this->model = $model;
    }

    /**
     * List model.
     *
     * @param string|null $model
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection|Category[]
     */
    public function list(string $model = null)
    {
        return $this->model
            ->where('status', 2)
            ->whereJsonContains('display_in', $model)
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * List model.
     *
     * @return \Illuminate\Support\Collection
     */
    public function lastN(int $count = 6)
    {
        return $this->model
            ->orderBy('id', 'desc')
            ->where('status', 2)
            ->with('translation')
            ->limit($count)
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
                $model->addMedia($data['image'], 'testimonial_image');

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

                $model->clearMediaCollection('testimonial_image');

                $model->addMedia($data['image'], 'testimonial_image');
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

            $model->clearMediaCollection('testimonial_image');

            $model->delete();

        } catch (\Exception $e){

            return false;
        }

        return true;
    }
}
