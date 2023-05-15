<?php

namespace Modules\Doctor\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\Doctor\Models\Doctor;
use Modules\Doctor\Models\DoctorWorkingDay;
use Illuminate\Http\Request;
use Modules\Doctor\Repositories\DoctorsRepository;

class DoctorController extends Controller
{
    private $doctorsRepository;

    /**
     * DoctorCategoryController constructor.
     *
     * @param DoctorsRepository $doctorsRepository
     */
    public function __construct(DoctorsRepository $doctorsRepository)
    {
        $this->doctorsRepository = $doctorsRepository;
    }

    /**
     * Get collection of doctors.
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function listData(Request $request)
    {
        # Repository to get collection of doctors.
        return $this->doctorsRepository->listData($request->all());
    }

    /**
     * Get collection of doctors.
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function list(Request $request)
    {
        # Repository to get collection of doctors.
        return $this->doctorsRepository->list($request->all());
    }

    /**
     * Get collection with pagination of doctors.
     *
     * @param Request $request
     * @uses \Modules\Doctor\Repositories\DoctorsRepository::get()
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\phpDocumentor\Reflection\Types\Collection
     */
    public function get(Request $request)
    {
        # Repository to get collection with pagination of doctors.
        return $this->doctorsRepository->get($request->all(), ['category']);
    }

    public function findDoctorAvailableTimes($doctor)
    {
        $doctor = Doctor::find($doctor);

        $workingMinutes = (strtotime($doctor->end_time) - strtotime($doctor->start_time)) / 60;

        $availableAppointmentsCount = $workingMinutes/30; // appointments every 30 minute
        $availableAppointments = [date( "g:i A",strtotime($doctor->start_time))];

        for ($i = 1 ; $i<= $availableAppointmentsCount; $i++) {
            $nextAppointment= 30 * $i * 60;
            array_push($availableAppointments, date( "g:i A",strtotime($doctor->start_time)+$nextAppointment));
        }

        return response()->json($availableAppointments);
    }

    /**
     * Update status.
     *
     * @param Doctor $doctor
     *
     * @return JsonResponse
     */
    public function changeStatus(Doctor $doctor): JsonResponse
    {
        if (! Gate::allows('edit redirections url')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( !$this->doctorsRepository->update($doctor, ['status' => ($doctor->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $doctor,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified doctor from storage.
     *
     * @param Doctor $doctor
     *
     * @return JsonResponse
     */
    public function destroy(Doctor $doctor): JsonResponse
    {
        if (! Gate::allows('delete redirections url')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( $doctor->medicalCase->count() > 0 ) {

            return response()->json([
                'code' => Response::HTTP_NOT_ACCEPTABLE,
                'message'=> __('messages.response.you_cant_delete_this')
            ], Response::HTTP_NOT_ACCEPTABLE); // Status code here

        }

        # check if repository not delete doctor return alert.
        if( !$this->doctorsRepository->delete($doctor) ){
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

    public function findDoctorAppointments($doctor,$branch)
    {
        $doctor = Doctor::find($doctor);

        $doctorAppointments = DoctorWorkingDay::where('doctor_id',$doctor->id)
                                               ->where('branch_id',$branch)
                                               ->whereDate('date', '>=', date('Y-m-d'))
                                               ->whereMonth('date', date('m'))
                                               ->get();

        return response()->json(['doctorAppointments' => $doctorAppointments]);
    }
}
