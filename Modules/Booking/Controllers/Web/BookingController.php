<?php

namespace Modules\Booking\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Booking\Models\Booking;
use Illuminate\Support\Facades\Redirect;
use Modules\Branch\Repositories\BranchesRepository;
use Modules\Booking\Repositories\BookingsRepository;
use Modules\Booking\Http\Requests\BookingStoreRequest;

class BookingController extends Controller
{
    private $viewsPath = 'Booking.Resources.views.';

     /**
     * BookingController constructor.
     * 
     * @param BranchesRepository $branchesRepository
     * @param BookingsRepository $bookingsRepository
     */
    public function __construct(BranchesRepository $branchesRepository, BookingsRepository $bookingsRepository)
    {
        $this->branchesRepository   = $branchesRepository;
        $this->bookingsRepository   = $bookingsRepository;
    }

    public function index(Request $request)
    {
        $branches = $this->branchesRepository->offersPage();
        return view($this->viewsPath . 'web.index', compact('branches'));
    }

    public function store(BookingStoreRequest $request)
    {

        if( !$this->bookingsRepository->create( array_merge($request->validated(), ['order_reference' => $this->generateUniqueCode(), 'type' => 1])) )
            return redirect()->back()->with('error', __('system.All required data must be entered'))->withInput();

        return redirect()->route('web.booking.index')->with('success', __('system.Your booking has been sent successfully'));


    }

    /**

     * Write referal_code on Method
     * @return response()
     */

    public function generateUniqueCode()

    {
        do {

            $referal_code = random_int(100000, 999999);

        } while (Booking::where("order_reference", "=", $referal_code)->first());

        return $referal_code;

    }

    public function validateAvailableBooking(Request $request)
    {
        $existBooking = Booking::selectRaw('bookings.*')
            ->where('doctor_id' , '=', $request->request->get('doctor_id'))
            ->where('branch_id' , '=', $request->request->get('branch_id'))
            ->where('available_time' , '=', $request->request->get('available_time'))
            ->whereDate('attendance_date' , $request->request->get('attendance_date'))
            ->first();

        return $availability = $existBooking ? 0 : 1 ;
    }

}
