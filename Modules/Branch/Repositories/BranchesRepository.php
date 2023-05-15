<?php

namespace Modules\Branch\Repositories;


use App\Enums\GeneralEnums;
use DB;
use Illuminate\Database\Eloquent\Model;
use Modules\Branch\Controllers\Api\BranchesController;
use Modules\Branch\Models\Branch;
use phpDocumentor\Reflection\Types\Collection;

class BranchesRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * BranchesRepository.
     *
     * @param Branch $branch
     */
    public function __construct(Branch $branch)
    {
        $this->model = $branch;
    }

    /**
     * List model.
     *
     * @used-by BranchesController::index()
     *
     * @return \Illuminate\Support\Collection
     */
    public function list(array $relations = [])
    {
        return $this->model
            ->orderBy('id', 'desc')
            ->where('status', 2)
            ->with($relations)
            ->get();
    }

    /**
     * Get model.
     *
     * @param array $payLoad
     * @param int $perPage
     * @used-by BranchesController::get()
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    public function get(array $payLoad = [], int $perPage = GeneralEnums::perPage)
    {
        $query = $this->model->query();

        return $query->orderBy('id', 'desc')->paginate($perPage);
    }

    /**
     * Get model.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function offersPage()
    {
        return $this->model->with('translation')->where('status', 2)->get();
    }

    /**
     * Get specification model by slug.
     *
     * @param string $slug
     * @return Model
     */
    public function showOffersPage(string $slug)
    {
        $model = $this->model
                    ->join('branch_translations', 'branches.id', '=', 'branch_translations.branch_id')
                    ->select('branch_translations.*', 'branches.id')
                    ->where(function($query) use($slug){
                        $query->where('branch_translations.slug', $slug);
                    })
                    ->where('branches.status', 2)
                    ->with('translation')->first();

        return $model;
    }

    /**
     * Get specification model by key.
     *
     * @param int $key
     *
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
        DB::beginTransaction();

        try {

            # save model.
            $model = $this->model->create($data);

            if( isset($data['categories']) ) {

                # assign categories to branch.
                $model->categories()->attach( array_keys($data['categories']) );

                # assign services to branch.
                $model->services()->attach( call_user_func_array('array_merge', $data['categories']) );
            }

            if (isset($data['offer_image']))
                $model->addMedia($data['offer_image'], 'branch_offer_image');

            DB::commit();

        } catch (\Exception $e){

            DB::rollback();

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

            if( isset($data['categories']) ) {

                # assign categories to branch.
                $model->categories()->sync( array_keys($data['categories']) );

                # assign services to branch.
                $model->services()->sync( call_user_func_array('array_merge', $data['categories']) );
            }

            if (isset($data['offer_image'])) {

                $model->clearMediaCollection('branch_offer_image');

                $model->addMedia($data['offer_image'], 'branch_offer_image');
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

            $model->clearMediaCollection('branch_offer_image');

            $model->delete();

        } catch (\Exception $e){

            return false;
        }

        return true;
    }
}
