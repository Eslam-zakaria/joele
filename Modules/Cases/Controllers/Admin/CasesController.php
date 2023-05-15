<?php

namespace Modules\Cases\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Modules\Branch\Repositories\BranchesRepository;
use Modules\Cases\Http\Requests\CaseStoreRequest;
use Modules\Cases\Http\Requests\CaseUpdateRequest;
use Modules\Cases\Models\MedicalCase;
use Modules\Cases\Repositories\CasesRepository;
use Modules\Category\Repositories\CategoriesRepository;
use Modules\Doctor\Repositories\DoctorsRepository;

class CasesController extends Controller
{
    private $casesRepository;
    private $categoriesRepository;
    private $branchesRepository;
    private $doctorsRepository;
    private $viewsPath = 'Cases.Resources.views.';

    /**
     * CasesController constructor.
     *
     * @param CasesRepository $casesRepository
     * @param CategoriesRepository $categoriesRepository
     * @param BranchesRepository $branchesRepository
     */
    public function __construct(
        CasesRepository $casesRepository,
        CategoriesRepository $categoriesRepository,
        BranchesRepository $branchesRepository,
        DoctorsRepository $doctorsRepository
    )
    {
        $this->casesRepository = $casesRepository;
        $this->categoriesRepository = $categoriesRepository;
        $this->branchesRepository = $branchesRepository;
        $this->doctorsRepository = $doctorsRepository;
    }

    /**
     * Display a listing of the cases.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list cases'))
            abort(403);

        return view("$this->viewsPath.index");
    }

    /**
     * Show the form for creating a new case.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        if (! Gate::allows('create case'))
            abort(403);

        # Repository list active categories by assign display model.
        $categories = $this->categoriesRepository->list('cases');

        # Repository to list branches.
        $branches = $this->branchesRepository->list();

        # Repository to list doctors.
        $doctors = $this->doctorsRepository->list(['translation', 'category.translation']);

        return view("$this->viewsPath.create", compact('categories', 'branches', 'doctors'));
    }

    /**
     * Store a newly created case in storage.
     *
     * @param CaseStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(CaseStoreRequest $request): RedirectResponse
    {
        # check if repository not create case return alert.
        if( !$this->casesRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('admin.cases.index')->with('success', __('messages.response.created'));
    }

    /**
     * Show the form for editing the specified case.
     *
     * @param MedicalCase $case
     *
     * @return Application|Factory|View
     */
    public function edit(MedicalCase $case)
    {
        if (! Gate::allows('edit case'))
            abort(403);

        # Repository list active categories by assign display model.
        $categories = $this->categoriesRepository->list('cases');

        # Repository to list branches.
        $branches = $this->branchesRepository->list();

        # Repository to list doctors.
        $doctors = $this->doctorsRepository->list(['translation', 'category.translation']);

        return view("$this->viewsPath.edit", compact('case', 'categories', 'branches', 'doctors'));
    }

    /**
     * Update the specified case in storage.
     *
     * @param CaseUpdateRequest $request
     * @param MedicalCase $case
     *
     * @return RedirectResponse
     */
    public function update(CaseUpdateRequest $request, MedicalCase $case): RedirectResponse
    {
        # check if repository not update case return alert.
        if( !$this->casesRepository->update( $case, $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.response.field_process'));

        return redirect()->route('admin.cases.index')->with('success', __('messages.response.updated'));
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
     * Replicate specified case
     *
     * @param MedicalCase $case
     *
     * @return RedirectResponse
     */
    public function replicate(MedicalCase $case): RedirectResponse
    {
        # check if repository not replicate case return alert.
        if( !$this->casesRepository->replicate($case) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('admin.cases.index')->with('success', __('messages.response.created'));
    }
}
