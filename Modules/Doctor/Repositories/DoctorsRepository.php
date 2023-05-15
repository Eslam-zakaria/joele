<?php

namespace Modules\Doctor\Repositories;

use App\Enums\GeneralEnums;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Doctor\Models\Doctor;

class DoctorsRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * DoctorsRepository.
     *
     * @param Doctor $blog
     */
    public function __construct(Doctor $blog)
    {
        $this->model = $blog;
    }

    /**
     * List model data.
     *
     * @return mixed
     */
    public function listData()
    {
        return $this->model->where('language', ( app()->getLocale() == 'en' ) ? 1 : 2)
            ->orWhere('language', 3)->get();
    }

    /**
     * List model.
     *
     * @param array $payLoad
     * @param array $relations
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    public function list(array $payLoad = [], array $relations = [], int $perPage = GeneralEnums::perPage)
    {
        $query = $this->model->query();

        $query->whereIn('language', [( app()->getLocale() == 'en' ) ? 1 : 2, 3]);

        if ( isset($payLoad['q']) && $payLoad['q'] ) {
            $query->whereHas('translations', function (Builder $query) use ($payLoad) {
                $query->where('name', 'LIKE', '%' . $payLoad['q'] . '%');
            });
        }

        if ( isset($payLoad['branch']) && $payLoad['branch'] ) {
            $query->whereHas('branches', function (Builder $q) use ($payLoad) {
                $q->where('branch_id', $payLoad['branch']);
            });
        }

        if ( isset($payLoad['specialization']) && $payLoad['specialization'] ) {
            $query->whereHas('specializations', function (Builder $query) use ($payLoad) {
                $query->where('specialization_id', $payLoad['specialization']);
            });
        }

        if( isset($payLoad['category']) && $payLoad['category'])
            $query->where('category_id', $payLoad['category']);

        if( isset($payLoad['sort']) && $payLoad['direction'])
            $query->orderBy($payLoad['sort'], $payLoad['direction']);

        if( isset($payLoad['status']) && $payLoad['status'])
            $query->where('status', $payLoad['status']);

        return $query->with($relations)->paginate($perPage);
    }

    /**
     * Get model.
     *
     * @param array $payLoad
     * @param array $relations
     * @param int $perPage
     * @used-by \Modules\Doctor\Controllers\Api\DoctorController::get()
     * @used-by \Modules\Doctor\Controllers\Web\DoctorController::index()
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\phpDocumentor\Reflection\Types\Collection
     */
    public function get(array $payLoad = [], array $relations = [], int $perPage = GeneralEnums::perPage)
    {
        $query = $this->model->query();

        if ( isset($payLoad['q']) && $payLoad['q'] ) {
            $query->whereHas('translations', function (Builder $query) use ($payLoad) {
                $query->where('name', 'LIKE', '%' . $payLoad['q'] . '%');
            });
        }

        if ( isset($payLoad['branch']) && $payLoad['branch'] ) {
            $query->whereHas('branches', function (Builder $query) use ($payLoad) {
                $query->where('branch_id', $payLoad['branch']);
            });
        }

        if ( isset($payLoad['specialization']) && $payLoad['specialization'] ) {
            $query->whereHas('specializations', function (Builder $query) use ($payLoad) {
                $query->where('specialization_id', $payLoad['specialization']);
            });
        }

        if( isset($payLoad['category']) && $payLoad['category'])
            $query->where('category_id', $payLoad['category']);

        if( isset($payLoad['sort']) && $payLoad['direction'])
            $query->orderBy($payLoad['sort'], $payLoad['direction']);

        if( isset($payLoad['status']) && $payLoad['status'])
            $query->where('status', $payLoad['status']);

        return $query->with($relations)->paginate($perPage);
    }

    /**
     * List model.
     *
     * @return \Illuminate\Support\Collection
     */
    public function lastN(int $count = 8)
    {
        return $this->model
            ->inRandomOrder()
            ->where('status', 2)
            ->with('translation', 'category', 'socialMedia', 'media')
            ->take($count)
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
        $lang = app()->getLocale() == 'en' ? 'en' : 'ar';

        return $this->model
            ->join('doctor_translations', 'doctors.id', '=', 'doctor_translations.doctor_id')
            ->select('doctor_translations.*', 'doctors.id', 'doctors.category_id', 'doctors.title_header_option', 'doctors.specialization_title_header_option')
            ->where(function($query) use($slug){
                $query->where('doctor_translations.slug', $slug);
            })
            ->where('doctors.status', 2)
            ->where('doctor_translations.locale', $lang)
            ->with('translation','category.translation', 'socialMedia','experience.translation','services.translation','medicalCase')->first();

    }

    /**
     * List model.
     *
     * @param int $branch
     * @return Model
     */
    public function listDoctorsByBranch(int $branch)
    {
        $lang = app()->getLocale() == 'en' ? 'en' : 'ar';

        $model = $this->model
                    ->join('doctor_translations', 'doctors.id', '=', 'doctor_translations.doctor_id')
                    ->join('branch_doctor', 'branch_doctor.doctor_id', '=', 'doctors.id')
                    ->select('doctor_translations.name','doctor_translations.locale', 'doctors.id', 'doctors.status','branch_doctor.branch_id')
                    ->where('doctors.status', 2)
                    ->where('doctor_translations.locale', $lang)
                    ->where('branch_doctor.branch_id', $branch)
                    ->with('translation')->get();

        return $model;
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
        DB::beginTransaction();

        try {

            # save model.
            $model = $this->model->create($data);

            if (isset($data['image']))
                $model->addMedia($data['image'], 'doctor_image');

            if (isset($data['social']))
                $model->socialMedia()->create($data['social']);

            if( isset($data['branches']) )
                $model->branches()->attach($data['branches']);

            if( isset($data['services']) )
                $model->services()->attach($data['services']);

            if( isset($data['specializations']) )
                $model->specializations()->attach($data['specializations']);

            if( isset($data['experience']) ){
                foreach ($data['experience'] as $experienceData) {
                    app(DoctorExperienceRepository::class)->create(array_merge($experienceData, ['doctor_id' => $model->id]));
                }
            }

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

            # Save image.
            if (isset($data['image'])) {

                # Clear old image
                $model->clearMediaCollection('doctor_image');

                $model->addMedia($data['image'], 'doctor_image');
            }

            # Save social Media.
            if (isset($data['social']))
                $model->socialMedia()->update($data['social']);


            # Save branches.
            if( isset($data['branches']) )
                $model->branches()->sync($data['branches']);

            # Save services.
            if( isset($data['services']) )
                $model->services()->sync($data['services']);

            # Save services.
            if( isset($data['specializations']) )
                $model->specializations()->sync($data['specializations']);

            # Save experience.
            if( isset($data['experience']) ){

                $model->experience()->delete();

                foreach ($data['experience'] as $experienceData) {
                    app(DoctorExperienceRepository::class)->create(array_merge($experienceData, ['doctor_id' => $model->id]));
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

            $model->clearMediaCollection('doctor_image');

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

            # assign branches to doctor.
            if( $model->branches->count() )
                $new_model->branches()->attach($model->branches->pluck('id')->toArray());

            # assign services to doctor.
            if( $model->services->count() )
                $new_model->services()->attach($model->services->pluck('id')->toArray());

            # assign specializations to doctor.
            if( $model->specializations->count() )
                $new_model->specializations()->attach($model->specializations->pluck('id')->toArray());

            # assign experience to doctor.
            if( $model->experience->count() ){

                foreach ($model->experience as $experienceData) {

                    $replicateExperienceData = $experienceData->replicateWithTranslations();

                    $new_model->experience()->save($replicateExperienceData);
                }

            }

            # Save social Media to doctor.
            if ( $model->socialMedia->count() ){

                $replicatesocialMedia = $model->socialMedia->replicate();

                $new_model->socialMedia()->save($replicatesocialMedia);
            }

        } catch (\Exception $e) {

            return false;
        }

        return true;
    }
}
