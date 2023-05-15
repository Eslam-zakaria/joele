<?php

namespace Modules\Category\Controllers\Admin;

use App\Enums\CategoriesRelationEnum;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Modules\Category\Models\Category;
use Modules\Category\Http\Requests\CategoryStoreRequest;
use Modules\Category\Http\Requests\CategoryUpdateRequest;
use Modules\Category\Repositories\CategoriesRepository;

class CategoriesController extends Controller
{
    private $categoriesRepository;
    private $viewsPath = 'Category.Resources.views.';

    /**
     * CategoriesController constructor.
     *
     * @param CategoriesRepository $categoriesRepository
     */
    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * Display a listing of the categories.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list categories'))
            abort(403);

        return view($this->viewsPath.'index');
    }

    /**
     * Show the form for creating a new category.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        if (! Gate::allows('create category'))
            abort(403);

        # Enum to get categories relation.
        $categoriesRelation = CategoriesRelationEnum::Models;

        # Enum to get grid options.
        $gridOptions = CategoriesRelationEnum::GridOptions;

        return view($this->viewsPath.'create', compact('categoriesRelation', 'gridOptions'));
    }

    /**
     * Store a newly created category in storage.
     *
     * @param CategoryStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(CategoryStoreRequest $request): RedirectResponse
    {
        # check if repository not create category return alert.
        if( !$this->categoriesRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.field_process'))->withInput();

        return redirect()->route('admin.categories.index')->with(['success' => 'Updated Successfully']);
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
     * Show the form for editing the specified category.
     *
     * @param Category $category
     *
     * @return Application|Factory|View
     */
    public function edit(Category $category)
    {
        if (! Gate::allows('edit category'))
            abort(403);

        # Enum to get categories relation.
        $categoriesRelation = CategoriesRelationEnum::Models;

        # Enum to get grid options.
        $gridOptions = CategoriesRelationEnum::GridOptions;

        return view($this->viewsPath.'edit', compact('category', 'categoriesRelation', 'gridOptions'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param CategoryUpdateRequest $request
     * @param Category $category
     *
     * @return RedirectResponse
     */
    public function update(CategoryUpdateRequest $request, Category $category): RedirectResponse
    {
        # check if repository not update category return alert.
        if( !$this->categoriesRepository->update( $category, $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.field_process'));

        return redirect()->route('admin.categories.index')->with('success', 'Updated Successfully');
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
}

