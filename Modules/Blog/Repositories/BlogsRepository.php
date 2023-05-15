<?php

namespace Modules\Blog\Repositories;

use App\Enums\GeneralEnums;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Blog\Models\Blog;
use Modules\FrequentlyQuestion\Models\FrequentlyQuestion;
use phpDocumentor\Reflection\Types\Collection;

class BlogsRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * BlogsRepository.
     *
     * @param Blog $blog
     */
    public function __construct(Blog $blog)
    {
        $this->model = $blog;
    }

    /**
     * List model.
     *
     * @param int $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function list($payload = [], $lang = 'ar',int $perPage = GeneralEnums::perPage)
    {
         $query = $this->model->query()->where('locale', $lang)->where('status', 2);

         if ( isset($payload['category']) )
             $query->where('category_id', $payload['category']);

        return $query->orderBy('id', 'desc')->paginate($perPage);
    }

    /**
     * List all active.
     *
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection|Blog[]
     */
    public function list_active()
    {
        return $this->model->where('status', 2)->get();
    }

    /**
     * Get model.
     *
     * @param int $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    public function get(array $payLoad = [], array $relations = [], int $perPage = GeneralEnums::perPage)
    {
        $query = $this->model->query();

        if ( isset($payLoad['q']) && $payLoad['q'] )
            $query->where('title', 'LIKE', '%' . $payLoad['q'] . '%');

        if( isset($payLoad['category']) && $payLoad['category'])
            $query->where('category_id', $payLoad['category']);

        if( isset($payLoad['sort']) && $payLoad['direction'])
            $query->orderBy($payLoad['sort'], $payLoad['direction']);

        if( isset($payLoad['status']) && $payLoad['status'])
            $query->where('status', $payLoad['status']);

        return $query->with($relations)
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
     * Get specification model by slug.
     *
     * @param int $key
     * @return Model
     */
    public function bySlug(string $key):? Model
    {
        return $this->model->where([["slug", $key], ['status', 2]])->first();
    }

     /**
     * Get specification model by slug.
     *
     * @param int $key
     * @return Model
     */
    public function byLang(int $key , $lang)
    {
        try {

            return $this->model->where('parent_id',$key)->where('locale','!=', $lang)->where('status', 2)->first();

        } catch (\Exception $e){

            return false;
        }
    }

    /**
     * Get related model.
     *
     * @return \Illuminate\Support\Collection
     */
    public function related(Model $model, int $count = 5 , $lang = 'ar')
    {
        return $this->model
            ->where('id', '!=', $model->id)
            ->where('category_id', $model->category_id)
            ->where('locale', $lang)
            ->with('category.translation')
            ->limit($count)
            ->get();
    }

    /**
     * List model.
     *
     * @return \Illuminate\Support\Collection
     */
    public function lastN(int $count = 6 , $lang = 'ar')
    {
        return $this->model
            ->orderBy('id', 'desc')
            ->where('status', 2)
            ->where('locale', $lang)
            ->with('category.translation', 'media')
            ->limit($count)
            ->get();
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
                $model->addMedia($data['image'], 'blog_image');

            if (isset($data['sections'])){

                foreach ($data['sections'] as $section){

                    $model->sections()->create($section);
                }

            }

            if( isset($data['experience']) ){
                foreach ($data['experience'] as $experienceData) {

                    $model->faqs()->create($experienceData);
                }
            }

            // if( isset($data['experience']) ){
            //     foreach ($data['experience'] as $experienceData) {
            //         $Question = FrequentlyQuestion::create(array_merge($experienceData, ['where_show' => 2]));
            //         $model->faqPage()->attach($Question);
            //     }
            // }
            if( $data['parent_id'] ){
                $updateParent = $this->model->where('id', $data['parent_id'])->first();
                $updateParent->update(['parent_id' => $model->id ]);
            }

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


            if( !empty($data['parent_id']) ){

                $removeOldParent = $this->model->where('id', $model->parent_id)->first();
                if($removeOldParent){
                    $removeOldParent->update(['parent_id' => Null]);
                }
            }
            # update model.
            $model->update($data);

            if( !empty($data['parent_id']) ){

                $updateParent = $this->model->where('id', $data['parent_id'])->first();
                $updateParent->update(['parent_id' => $model->id ]);
            }

            if (isset($data['image'])) {

                $model->clearMediaCollection('blog_image');

                $model->addMedia($data['image'], 'blog_image');
            }

            if (isset($data['sections'])){

                $model->sections()->delete();

                foreach ($data['sections'] as $section){

                    $model->sections()->create($section);
                }

            }

            if( isset($data['experience']) ){
                foreach ($data['experience'] as $experienceData) {

                    $model->faqs()->create($experienceData);
                }
            }

            // if( isset($data['experience']) ){
            //     foreach ($data['experience'] as $experienceData) {
            //         $Question = FrequentlyQuestion::create(array_merge($experienceData, ['where_show' => 2]));
            //         $model->faqPage()->attach($Question);
            //     }
            // }

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

            if( $model->parent_id ){

                $removeOldParent = $this->model->where('id', $model->parent_id)->first();
                $removeOldParent->update(['parent_id' => Null]);
            }

            $model->clearMediaCollection('blog_image');

            $model->delete();

        } catch (\Exception $e){

            return false;
        }

        return true;
    }
}
