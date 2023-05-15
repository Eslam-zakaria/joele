<?php

namespace Modules\Branch\Controllers\Web;

use App\Http\Controllers\Controller;
use Modules\Branch\Repositories\BranchesRepository;

class BranchesController extends Controller
{
    private $viewsPath = 'Branch.Resources.views.';
    private $branchesRepository;


    /**
     * BranchesController constructor.
     *
     * @param BranchesRepository $branchesRepository
     */
    public function __construct(BranchesRepository $branchesRepository)
    {
        $this->branchesRepository = $branchesRepository;
    }

    /**
     * Display a listing of the branches.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        # Repository to list branches.
        $branches = $this->branchesRepository->list();

        return view("$this->viewsPath.web.index", compact('branches'));
    }

}
