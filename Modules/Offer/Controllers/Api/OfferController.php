<?php

namespace Modules\Offer\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\Offer\Models\Offer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Modules\Offer\Repositories\OffersRepository;

class OfferController extends Controller
{
    private $offersRepository;

    /**
     * OffersRepository $offersRepository.
     *
     * @param OffersRepository $offersRepository
     */
    public function __construct(OffersRepository $offersRepository)
    {
        $this->offersRepository = $offersRepository;
    }

    public function index(Request $request)
    {
            $users = Offer::query()
                ->select('offers.*')
                ->when($request->get('q'), function (Builder $query) {
                    $word = request()->get('q');
                    /*$query->join('offer_translations', function (JoinClause $join) {
                        $join->on('offer_translations.offer_id', '=', 'offers.id');
                    });*/

                    return $query->whereRaw("(offer_translations.name like '%{$word}%') or offers.id = '%{$word}%'");
                })
                ->orderBy('offers.'.request()->get('sort', 'created_at'), request()->get('direction', 'DESC'))
                ->orderBy('offers.id', request()->get('direction', 'DESC'))
                ->with('category')
                ->paginate(10);

        return response()->json($users);
    }

    /**
     * Update status.
     *
     * @param Offer $offer
     *
     * @return JsonResponse
     */
    public function changeStatus(Offer $offer): JsonResponse
    {
        if (! Gate::allows('edit offer')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( !$this->offersRepository->update($offer, ['status' => ($offer->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $offer,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified category from storage.
     *
     * @param Offer $offer
     *
     * @return JsonResponse
     */
    public function destroy(Offer $offer): JsonResponse
    {
        if (! Gate::allows('delete offer')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        # check if repository not delete category return alert.
        if( !$this->offersRepository->delete($offer) ){
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'message'=> __('messages.response.deleted')
        ], Response::HTTP_OK); // Status code here
    }
}
