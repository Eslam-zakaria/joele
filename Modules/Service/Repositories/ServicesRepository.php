<?php

namespace Modules\Service\Repositories;


use App\Enums\GeneralEnums;
//use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Modules\FrequentlyQuestion\Models\FrequentlyQuestion;
use Modules\Service\Models\Service;
use phpDocumentor\Reflection\Types\Collection;

class ServicesRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * ServicesRepository.
     *
     * @param Service $model
     */
    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    /**
     * List model.
     *
     * @param int $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function list(int $perPage = GeneralEnums::perPage)
    {
        $query = $this->model->query()->where('status', 2);

        if( isset($searchQuery['q']) && $searchQuery['q'] ) {
            $query->whereHas('translations', function (Builder $query) use ($searchQuery) {
                $query->where('name', 'LIKE', '%' . $searchQuery['q'] . '%');
            });
        }

        return $query->orderBy('id', 'desc')
            ->with('category')
            ->paginate($perPage);
    }

    /**
     * Get all active services.
     *
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection|Service[]
     */
    public function all_active()
    {
        return $this->model->where('status', 2)->with('translation')->get();
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
        $query = $this->model->query();

        if( isset($searchQuery['q']) && $searchQuery['q'] ) {
            $query->whereHas('translations', function (Builder $query) use ($searchQuery) {
                $query->where('name', 'LIKE', '%' . $searchQuery['q'] . '%');
            });
        }

        if( isset($searchQuery['status']) && $searchQuery['status'])
            $query->where('status', $searchQuery['status']);

        return $query->orderBy('id', 'desc')
            ->with('category.translation', 'media', 'translation')
            ->paginate($perPage);
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
     * Get model.
     *
     * @param int $category
     * @param int $perPage
     *
     * @return Builder|\Illuminate\Database\Eloquent\Collection|Service
     */
    public function servicesPage(int $category , int $perPage = GeneralEnums::perPage)
    {
        return $this->model
            ->where([['category_id', $category], ['status', 2]])
            ->whereIn('language', [( app()->getLocale() == 'en' ) ? 1 : 2, 3])
            ->with('translation')
            ->get();
    }

    /**
     * Get specification model by slug.
     *
     * @param string $slug
     * @return Model
     */
    public function detailsPage(string $slug)
    {
        return $this->model
            ->join('service_translations', 'services.id', '=', 'service_translations.service_id')
            ->select('service_translations.*', 'services.id', 'services.category_id','services.status', 'services.title_header_option')
            ->where(function($query) use($slug){
                $query->where('service_translations.slug', $slug)
                    ->orWhere('service_translations.new_slug', $slug);
            })
            ->where('services.status', 2)
            ->with('translation','category')->first();
    }

    /**
     * Get specification model by slug.
     *
     * @param int $id
     * @param int $category
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function servicesRelated(int $id , int $category)
    {
        return $this->model->with('translation')
            ->where('id','!=', $id)
            ->where('category_id',$category)
            ->where('status', 2)
            ->orderBy('id','desc')
            ->limit(9)
            ->get();
    }

    /**
     * Get specification active model.
     *
     * @param int $key
     * @param string $model
     *
     * @return Model
     */
    public function find_active(int $key, string $model):? Model
    {
        return $this->model
            ->whereJsonContains('display_in', $model)
            ->where('id', $key)
            ->where('status', 2)
            ->first();
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
                $model->addMedia($data['image'], 'service_image');

            if( isset($data['experience']) ){
                foreach ($data['experience'] as $experienceData) {
                    $Question = FrequentlyQuestion::create(array_merge($experienceData, ['where_show' => 1]));
                    $model->faqPage()->attach($Question);
                }
            }

        } catch (\Exception $e){

            dd($e);

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

                $model->clearMediaCollection('service_image');

                $model->addMedia($data['image'], 'service_image');
            }


            if( isset($data['experience']) ){
                foreach ($data['experience'] as $experienceData) {
                    $Question = FrequentlyQuestion::create(array_merge($experienceData, ['where_show' => 1]));
                    $model->faqPage()->attach($Question);
                }
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

            $model->clearMediaCollection('service_image');

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
            $new_model->translate('ar')->name = $new_model->translate('ar')->name . ' copy';
            $new_model->translate('en')->name = $new_model->translate('en')->name . ' copy';
            $new_model->translate('ar')->slug = $new_model->translate('ar')->slug . '-copy';
            $new_model->translate('en')->slug = $new_model->translate('en')->slug . '-copy';
            $new_model->save();

            $new_model->faqPage()->attach($model->faqPage->pluck('id')->toArray());

        } catch (\Exception $e) {

            return false;
        }

        return true;
    }
}
