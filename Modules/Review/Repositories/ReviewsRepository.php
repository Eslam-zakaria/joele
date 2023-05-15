<?php

namespace Modules\Review\Repositories;

use App\Enums\GeneralEnums;
use Illuminate\Database\Eloquent\Model;
use Modules\Blog\Models\Blog;
use Modules\Review\Models\Review;
use Modules\Review\Models\ReviewAnswer;
use phpDocumentor\Reflection\Types\Collection;

class ReviewsRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * ReviewsRepository.
     *
     * @param Review $review
     */
    public function __construct(Review $review)
    {
        $this->model = $review;
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

        if(isset($payload['q']) && $payload['q']) {

            $query->where('name', 'LIKE', '%' . $payload['q'] . '%')
                ->orWhere('phone', $payload['q']);

        }

        if( isset($payload['from']) && $payload['from'] )
            $query->whereDate('created_at', '>=', $payload['from']);

        if( isset($payload['to']) && $payload['to'] )
            $query->whereDate('created_at', '<=', $payload['to']);

        if( isset($payload['status']) && $payload['status'] )
            $query->where('status', $payload['status']);

        if( isset($payload['doctor']) && $payload['doctor'] )
            $query->where('doctor_id', $payload['doctor']);

        if( isset($payload['branch']) && $payload['branch'] )
            $query->where('branch_id', $payload['branch']);

        return $query->orderBy('id', 'desc')
            ->with('branch', 'doctor')
            ->get();
    }

    /**
     * Get model.
     *
     * @param int $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    public function get(array $payload = [], int $perPage = GeneralEnums::perPage)
    {
        $query = $this->model->query();

        if(isset($payload['q']) && $payload['q']) {

            $query->where('name', 'LIKE', '%' . $payload['q'] . '%')
                ->orWhere('phone', $payload['q']);

        }

        if( isset($payload['from']) && $payload['from'] )
            $query->whereDate('created_at', '>=', $payload['from']);

        if( isset($payload['to']) && $payload['to'] )
            $query->whereDate('created_at', '<=', $payload['to']);

        if( isset($payload['status']) && $payload['status'] )
            $query->where('status', $payload['status']);

        if( isset($payload['doctor']) && $payload['doctor'] )
            $query->where('doctor_id', $payload['doctor']);

        if( isset($payload['branch']) && $payload['branch'] )
            $query->where('branch_id', $payload['branch']);

        return $query->orderBy('id', 'desc')
            ->with('branch', 'doctor')
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
//            ->orderBy('id', 'desc')
            ->inRandomOrder()
            ->where('status', 2)
            ->limit($count)
            ->with('doctor.media')
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

            foreach ($data['questions'] as $key => $answer){

                ReviewAnswer::create([
                    'review_id' => $model->id,
                    'review_question_id' => $key,
                    'answer' => $answer,
                ]);

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
