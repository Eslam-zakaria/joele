<?php

namespace Modules\FrequentlyQuestion\Repositories;

use App\Enums\GeneralEnums;
use Illuminate\Database\Eloquent\Model;
use Modules\FrequentlyQuestion\Models\FrequentlyQuestion;
use phpDocumentor\Reflection\Types\Collection;

class FrequentlyQuestionRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * FrequentlyQuestionRepository.
     *
     * @param FrequentlyQuestion $frequentlyQuestion
     */
    public function __construct(FrequentlyQuestion $frequentlyQuestion)
    {
        $this->model = $frequentlyQuestion;
    }

    /**
     * List model data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function list()
    {
        return $this->model
            ->orderBy('id', 'desc')
            ->where('status', 2)
            ->whereNotNull('category_id')
            ->whereIn('language', [( app()->getLocale() == 'en' ) ? 1 : 2, 3])
            ->with('category')
            ->get();
    }

    /**
     * List model data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPages(int $where_show = 0)
    {
        return $this->model
            ->orderBy('id', 'desc')
            ->where('where_show', $where_show)
            ->get();
    }

    /**
     * Get model.
     *
     * @param array $searchQuery
     * @param int $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    public function get(array $searchQuery = [], int $perPage = GeneralEnums::perPage)
    {
        return $this->model->orderBy('id', 'desc')
            ->whereNotNull('category_id')
            ->with('category', 'translation')
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
            $new_model->translate('ar')->question = $new_model->translate('ar')->question . ' copy';
            $new_model->translate('en')->question = $new_model->translate('en')->question . ' copy';
            $new_model->save();

        } catch (\Exception $e) {

            return false;
        }

        return true;
    }
}
