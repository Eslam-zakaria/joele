<?php

namespace Modules\Review\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Modules\Review\Models\Review;
use Modules\Review\Repositories\ReviewsRepository;

class ReviewsController extends Controller
{
    private $reviewsRepository;

    /**
     * ReviewsController constructor.
     *
     * @param ReviewsRepository $reviewsRepository
     */
    public function __construct(ReviewsRepository $reviewsRepository)
    {
        $this->reviewsRepository = $reviewsRepository;
    }

    /**
     * Get collection with pagination of reviews.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\phpDocumentor\Reflection\Types\Collection
     */
    public function index(Request $request)
    {
        # Repository to get collection with pagination of reviews.
        return $this->reviewsRepository->get($request->all());
    }

    /**
     * Update status.
     *
     * @param Review $review
     *
     * @return JsonResponse
     */
    public function changeStatus(Review $review): JsonResponse
    {
        if( !$this->reviewsRepository->update($review, ['status' => ($review->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $review,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified review from storage.
     *
     * @param Review $review
     *
     * @return JsonResponse
     */
    public function destroy(Review $review): JsonResponse
    {
        # check if repository not delete review return alert.
        if( !$this->reviewsRepository->delete($review) ){
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
