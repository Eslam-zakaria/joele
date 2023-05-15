<?php

namespace Modules\Cases\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Branch\Repositories\BranchesRepository;
use Modules\Cases\Repositories\CasesRepository;
use Modules\Category\Repositories\CategoriesRepository;

class CasesController extends Controller
{
    private $viewsPath = 'Cases.Resources.views.';
    private $casesRepository;
    private $categoriesRepository;
    private $branchesRepository;

    /**
     * CasesController constructor.
     *
     * @param CasesRepository $casesRepository
     * @param CategoriesRepository $categoriesRepository
     * @param BranchesRepository $branchesRepository
     */
    public function __construct(CasesRepository $casesRepository, CategoriesRepository $categoriesRepository, BranchesRepository $branchesRepository)
    {
        $this->casesRepository = $casesRepository;
        $this->categoriesRepository = $categoriesRepository;
        $this->branchesRepository = $branchesRepository;
    }

    /**
     * Display a listing of the cases.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        # Repository to list cases.
        $cases = $this->casesRepository->list($request->all());

        # Repository to list categories.
        $categories = $this->categoriesRepository->list('cases');

        # Repository to list branches.
        $branches = $this->branchesRepository->list();

        return view("$this->viewsPath.web.index", compact('cases', 'categories', 'branches'));
    }

}
