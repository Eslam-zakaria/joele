<?php

namespace Modules\Booking\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\Booking\Models\Booking;
use Illuminate\Http\Request;
use Modules\Booking\Repositories\BookingsRepository;

class BookingController extends Controller
{
    private $bookingsRepository;

    /**
     * BookingController constructor.
     *
     * @param BookingsRepository $bookingsRepository
     */
    public function __construct(BookingsRepository $bookingsRepository)
    {
        $this->bookingsRepository = $bookingsRepository;
    }

    /**
     * Get collection of booking.
     *
     * @param Request $request
     * @uses \Modules\Booking\Repositories\BookingsRepository::get()
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\phpDocumentor\Reflection\Types\Collection
     */
    public function index(Request $request)
    {
        return $this->bookingsRepository->get($request->all());
    }

    /**
     * Update booking status.
     *
     * @param Booking $booking
     *
     * @return JsonResponse
     */
    public function changeStatus(Booking $booking): JsonResponse
    {
        if (! Gate::allows('edit booking')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( !$this->bookingsRepository->update($booking, ['status' => ($booking->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $booking,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified booking from storage.
     *
     * @param Booking $booking
     *
     * @return JsonResponse
     */
    public function destroy(Booking $booking): JsonResponse
    {
        if (! Gate::allows('delete booking')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        # check if repository not delete lecture return alert.
        if( !$this->bookingsRepository->delete($booking) ){
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
