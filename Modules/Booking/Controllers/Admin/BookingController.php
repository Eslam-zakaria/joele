<?php

namespace Modules\Booking\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Booking\Models\Booking;
use Illuminate\Http\Request;
use Modules\Booking\Repositories\BookingsRepository;

class BookingController extends Controller
{
    private $bookingsRepository;
    private $viewsPath = 'Booking.Resources.views.';

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
     * Display a listing of the bookings.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view("$this->viewsPath.index");
    }

    /**
     * Show the form for editing the specified booking.
     *
     * @param Booking $booking
     *
     * @return Application|Factory|View
     */
    public function edit(Booking $booking)
    {
        return view("$this->viewsPath.edit", compact('booking'));
    }

    /**
     * Update the specified booking in storage.
     *
     * @param Request $request
     * @param Booking $booking
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Booking $booking): RedirectResponse
    {
        # check if repository not update booking return alert.
        if( !$this->bookingsRepository->update( $booking, $request->all() ) )
            return redirect()->back()->with('failed', __('messages.response.field_process'));

        return redirect()->route('admin.bookings.index')->with('success', __('messages.response.updated'));
    }

    public function exportCsv(Request $request)
    {
        $fileName = 'bookings.csv';

        # Repository to list bookings.
        $bookings = $this->bookingsRepository->list($request->all());

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('name', 'phone', 'status', 'notes', 'branch', 'doctor', 'offer','attendance_date' ,'available_time','created_at');

        $callback = function () use ($bookings, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, $columns);

            foreach ($bookings as $booking) {
                $row['name']   = $booking->name;
                $row['phone']  = $booking->phone;
                $row['status'] = $booking->statusData['label'] ?? 'N/A';
                $row['notes']  =  $booking->note ? $booking->note : 'N/A';
                $row['branch'] = $booking->branch->name ?? 'N/A';
                $row['doctor'] = $booking->doctor->name ?? 'N/A';
                $row['offer'] = $booking->offer->name ?? 'N/A';
                $row['attendance_date'] = $booking->attendance_date;
                $row['available_time'] = $booking->available_time;
                $row['created_at'] = date('Y-m-d H:i A', strtotime($booking->created_at));
                fputcsv($file, array($row['name'], $row['phone'], $row['status'] ,$row['notes'], $row['branch'], $row['doctor'], $row['offer'], $row['attendance_date'], $row['available_time'], $row['created_at']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

