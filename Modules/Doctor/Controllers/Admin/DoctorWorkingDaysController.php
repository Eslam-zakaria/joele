<?php

namespace Modules\Doctor\Controllers\Admin;

use App\Enums\GeneralEnums;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Modules\Doctor\Http\Requests\DoctorWorkingDaysRequest;
use Modules\Doctor\Models\Doctor;
use Modules\Doctor\Models\DoctorWorkingDay;

class DoctorWorkingDaysController
{
    private $viewsPath = 'Doctor.Resources.views.';

    /**
     * Get doctor working days.
     *
     * @param Doctor $doctor
     * @param array $calendar
     *
     * @return Application|Factory|\Illuminate\View\View
     */
    public function index(Doctor $doctor, array $calendar = [])
    {
        $oldWorkingDaysArray = [];

        foreach ($doctor->workingDays->groupBy('branch_id') as $workingDaysBranchesKey => $workingDaysBranches){

            foreach ($workingDaysBranches->groupBy('month') as $monthKey => $workingDaysBranchesMonth){

                $oldWorkingDaysArray[$workingDaysBranchesKey][$monthKey] = $workingDaysBranches->pluck('date')->toArray();

            }

        }

        # Enum to list days name.
        $days = GeneralEnums::Days;

        $monthsArray = [];

        for($month = 0 ; $month <= 1 ; $month++) {

            $currentMonth = Carbon::now()->startOfMonth()->addMonth($month);

            $endOFCurrentMonth = $currentMonth->endOfMonth()->format('d');

            $startOfMonth = $currentMonth->startOfMonth();

            $calendar = [];

            for ( $monthCalendar = 1 ; $monthCalendar <= (int)$endOFCurrentMonth ; $monthCalendar++ ){

                $trialExpires = $startOfMonth->addDays(( $monthCalendar == 1 ? 0 : 1 ));

                $dayOfWeek = $trialExpires->dayOfWeek;

                $data = [
                    'day_number' => $monthCalendar,
                    'date' => $trialExpires->format('Y-m-d'),
                    'day_in_week' => $dayOfWeek,
                    'carbon_day_name' => $trialExpires->format('D'),
                    'day_name' => $days[$dayOfWeek],
                ];

                array_push($calendar, $data);

            }

            $monthsArray[$currentMonth->format('M')]['calendar'] = $calendar;
            $monthsArray[$currentMonth->format('M')]['month'] = (int)$currentMonth->format('m');
        }

        return view("$this->viewsPath.schedule", compact('doctor', 'monthsArray', 'oldWorkingDaysArray'));
    }

    public function store(DoctorWorkingDaysRequest $request, Doctor $doctor)
    {
        $doctor->workingDays()->delete();

        foreach ($request->appointment as $appointmentBranch => $appointment){

            foreach ($appointment as $appointmentMonth => $appointmentData){

                foreach ($appointmentData as $date){

                    DoctorWorkingDay::create([
                        'date' => $date,
                        'month' => $appointmentMonth,
                        'branch_id' => $appointmentBranch,
                        'doctor_id' => $doctor->id,
                    ]);
                }
            }

        }

        return redirect()->route('admin.doctor.working-days.index', $doctor->id);
    }
}
