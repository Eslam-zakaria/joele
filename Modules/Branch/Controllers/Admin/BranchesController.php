<?php

namespace Modules\Branch\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Modules\Branch\Models\Branch;
use Modules\Branch\Repositories\BranchesRepository;
use Modules\Category\Repositories\CategoriesRepository;
use Modules\Branch\Http\Requests\BranchStoreRequest;
use Modules\Branch\Http\Requests\BranchUpdateRequest;

class BranchesController extends Controller
{
    private $branchesRepository;
    private $categoriesRepository;
    private $viewsPath = 'Branch.Resources.views.';

    /**
     * BranchesController constructor.
     *
     * @param BranchesRepository $branchesRepository
     * @param CategoriesRepository $categoriesRepository
     */
    public function __construct(BranchesRepository $branchesRepository, CategoriesRepository $categoriesRepository)
    {
        $this->branchesRepository = $branchesRepository;
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * Display a listing of the branches.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list branches'))
            abort(403);

        return view($this->viewsPath.'index');
    }

    /**
     * Show the form for creating a new branch.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        if (! Gate::allows('create branch'))
            abort(403);

        # Repository list active categories by assign display model.
        $categories = $this->categoriesRepository->list('branches', ['services', 'translations']);

        return view($this->viewsPath.'create', compact('categories'));
    }

    /**
     * Store a newly created branch in storage.
     *
     * @param BranchStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(BranchStoreRequest $request): RedirectResponse
    {
        # check if repository not create branch return alert.
        if( !$this->branchesRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.field_process'))->withInput();

        return redirect()->route('admin.branches.index')->with('success', __('messages.response.created'));
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
     * Show the form for editing the specified branch.
     *
     * @param Branch $branch
     *
     * @return Application|Factory|View
     */
    public function edit(Branch $branch)
    {
        # Repository list active categories by assign display model.
        $categories = $this->categoriesRepository->list('branches', ['services', 'translations']);

        return view($this->viewsPath.'edit', compact('branch', 'categories'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param BranchUpdateRequest $request
     * @param Branch $branch
     *
     * @return RedirectResponse
     */
    public function update(BranchUpdateRequest $request, Branch $branch): RedirectResponse
    {
        # check if repository not update branch return alert.
        if( !$this->branchesRepository->update( $branch, $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.field_process'));

        return redirect()->route('admin.branches.index')->with('success', __('messages.response.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id)
    {

    }
}

