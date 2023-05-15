<?php

namespace Modules\Doctor\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Branch\Repositories\BranchesRepository;
use Modules\Doctor\Repositories\DoctorsRepository;
use Modules\Category\Repositories\CategoriesRepository;
use Modules\Specialization\Repositories\SpecializationsRepository;


class DoctorController extends Controller
{
    private $viewsPath = 'Doctor.Resources.views.';
    protected $doctorsRepository;
    protected $categoriesRepository;
    protected $branchesRepository;

    /**
     * DoctorController constructor.
     *
     * @param DoctorsRepository $doctorsRepository
     * @param CategoriesRepository $categoriesRepository
     * @param BranchesRepository $branchesRepository
     */
    public function __construct(DoctorsRepository $doctorsRepository, CategoriesRepository $categoriesRepository, BranchesRepository $branchesRepository)
    {
        $this->doctorsRepository = $doctorsRepository;
        $this->categoriesRepository = $categoriesRepository;
        $this->branchesRepository = $branchesRepository;
    }

    /**
     * Display a listing of the doctors.
     *
     * @param Request $request
     * @uses \Modules\Category\Repositories\CategoriesRepository::list()
     * @uses \Modules\Doctor\Repositories\DoctorsRepository::get()
     * @uses \Modules\Branch\Repositories\BranchesRepository::list()
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        # Repository to list categories.
        $categories = $this->categoriesRepository->list('doctors', ['translation']);

        # Repository to list doctors.
        $doctors = $this->doctorsRepository->list(array_merge($request->all(), ['status' => 2]), ['translation', 'media', 'category', 'socialMedia']);

        # Repository to list branches.
        $branches = $this->branchesRepository->list(['translation']);

        # Repository to list specializations.
        $specializations = app(SpecializationsRepository::class)->list($request->all());

        return view( "$this->viewsPath.web.index", compact('doctors','request','categories', 'branches', 'specializations'));
    }

    /**
     * Display the specified doctor.
     *
     * @param string $slug
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function details(string $slug)
    {
        # Repository to get doctor by slug.
        $doctor = $this->doctorsRepository->detailsPage($slug);

         //check if no data response redirect on home with 301
         if( !$doctor )
             return abort(404);

        $specializations = app(SpecializationsRepository::class)->getBypluck();

        $doctorspecialistIds = [];
        if (count($doctor->specializations) > 0 ) {
            foreach($doctor->specializations as $specialist) {
                $doctorspecialistIds[] = $specialist->id;
            }
        }

        return view($this->viewsPath.'web.details', compact('doctor','specializations','doctorspecialistIds'));
    }
}
