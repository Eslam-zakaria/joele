<?php

namespace Modules\Offer\Repositories;

use App\Enums\GeneralEnums;
use Illuminate\Database\Eloquent\Model;
use Modules\Offer\Models\Offer;
use phpDocumentor\Reflection\Types\Collection;

class OffersRepository implements EloquentRepositoryInterface
{
    protected $model;

    /**
     * OffersRepository.
     *
     * @param Offer $Offer
     */
    public function __construct(Offer $Offer)
    {
        $this->model = $Offer;
    }

    /**
     * List model.
     *
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
     * List model.
     *
     * @param int $category
     * @param array $offerId
     * @return Model
     */
    public function getOffers(array $offerId, int $category = null)
    {
        $lang = app()->getLocale() == 'en' ? 'en' : 'ar';
        $model = $this->model
                    ->join('offer_translations', 'offers.id', '=', 'offer_translations.offer_id')
                    ->select('offer_translations.*', 'offers.id', 'offers.category_id' , 'offers.price')
                    ->when($category, function ($query) use ($category) {
                        $query->where('offers.category_id', $category);
                    })
                    ->whereIn('offers.id',$offerId)
                    ->where('offers.status', 2)
                    ->where('offer_translations.locale', $lang)
                    ->with('translation')->paginate(16);

        return $model;
    }

    /**
     * List model.
     * @param int $offerId
     * @return Model
     */
    public function offerDetails(int $offerId)
    {
        $lang = app()->getLocale() == 'en' ? 'en' : 'ar';
        $model = $this->model
                    ->join('offer_translations', 'offers.id', '=', 'offer_translations.offer_id')
                    ->select('offer_translations.*', 'offers.id','offers.price')
                    ->where('offers.id',$offerId)
                    ->where('offers.status', 2)
                    ->where('offer_translations.locale', $lang)
                    ->with('translation')->first();

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
        try {

            # save model.
            $model = $this->model->create($data);

            if (isset($data['image']))
                $model->addMedia($data['image'], 'offer_image');

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

                $model->clearMediaCollection('offer_image');

                $model->addMedia($data['image'], 'offer_image');
            }

            if( isset($data['branches']) )
                $model->branches()->sync($data['branches']);

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

            $model->clearMediaCollection('offer_image');

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
            $new_model->save();

        } catch (\Exception $e) {

            return false;
        }

        return true;
    }
}
