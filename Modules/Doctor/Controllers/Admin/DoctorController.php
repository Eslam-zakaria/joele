<?php

namespace Modules\Doctor\Controllers\Admin;

use App\Enums\GeneralEnums;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\Branch\Repositories\BranchesRepository;
use Modules\Category\Repositories\CategoriesRepository;
use Modules\Doctor\Models\Doctor;
use Modules\Doctor\Repositories\DoctorsRepository;
use Modules\Doctor\Http\Requests\DoctorStoreRequest;
use Modules\Doctor\Http\Requests\DoctorUpdateRequest;
use Modules\Specialization\Repositories\SpecializationsRepository;

class DoctorController extends Controller
{
    private $doctorsRepository;
    private $categoriesRepository;
    private $viewsPath = 'Doctor.Resources.views.';

    /**
     * DoctorController constructor.
     *
     * @param DoctorsRepository $doctorsRepository
     * @param CategoriesRepository $categoriesRepository
     */
    public function __construct(DoctorsRepository $doctorsRepository, CategoriesRepository $categoriesRepository)
    {
        $this->doctorsRepository = $doctorsRepository;
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * Display a listing of the doctors.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list doctors'))
            abort(403);

        return view("$this->viewsPath.index");
    }

    /**
     * Show the form for creating a new doctor.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        if (! Gate::allows('create doctor'))
            abort(403);

        # Repository list active categories by assign display model.
        $categories = $this->categoriesRepository->list('doctors');

        # Repository to list branches.
        $branches = app(BranchesRepository::class)->list();

        # Repository to list specializations.
        $specializations = app(SpecializationsRepository::class)->list();

        return view("$this->viewsPath.create", compact('categories', 'branches', 'specializations'));
    }

    /**
     * Store a newly created doctor in storage.
     *
     * @param DoctorStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(DoctorStoreRequest $request): RedirectResponse
    {
        # check if repository not create doctor return alert.
        if( !$this->doctorsRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('admin.doctors.index')->with('success', __('messages.response.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified doctor.
     *
     * @param Doctor $doctor
     *
     * @return Application|Factory|View
     */
    public function edit(Doctor $doctor)
    {
        if (! Gate::allows('edit doctor'))
            abort(403);

        # Repository to list branches.
        $branches = app(BranchesRepository::class)->list();

        # Repository list active categories by assign display model.
        $categories = $this->categoriesRepository->list('doctors');

        # Repository to list specializations.
        $specializations = app(SpecializationsRepository::class)->getBypluck();

        $doctorspecialistIds = $doctor->specializations->pluck('id')->toArray();

        return view("$this->viewsPath.edit", compact('doctor', 'categories', 'branches', 'specializations','doctorspecialistIds'));
    }

    /**
     * Update the specified doctor in storage.
     *
     * @param DoctorUpdateRequest $request
     * @param Doctor $doctor
     *
     * @return RedirectResponse
     */
    public function update(DoctorUpdateRequest $request, Doctor $doctor): RedirectResponse
    {
        # check if repository not update doctor return alert.
        if( !$this->doctorsRepository->update($doctor, $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.response.field_process'));

        return redirect()->route('admin.doctors.index')->with('success', __('messages.response.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return void
     */
    public function destroy(int $id)
    {
        //
    }

    /**
     * Replicate specified doctor
     *
     * @param Doctor $doctor
     *
     * @return RedirectResponse
     */
    public function replicate(Doctor $doctor): RedirectResponse
    {
        # check if repository not replicate doctor return alert.
        if( !$this->doctorsRepository->replicate($doctor) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('admin.doctors.index')->with('success', __('messages.response.created'));
    }
}

