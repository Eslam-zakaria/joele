<?php

namespace Modules\FrequentlyQuestion\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Modules\FrequentlyQuestion\Http\Requests\QuestionCategoryStoreRequest;
use Modules\FrequentlyQuestion\Http\Requests\QuestionCategoryUpdateRequest;
use Modules\FrequentlyQuestion\Models\QuestionCategory;
use Modules\FrequentlyQuestion\Repositories\QuestionCategoriesRepository;

class QuestionsCategoryController extends controller
{
    private $questionCategoriesRepository;
    private $viewsPath = 'FrequentlyQuestion.Resources.views.category.';

    /**
     * QuestionsCategoryController constructor.
     *
     * @param QuestionCategoriesRepository $questionCategoriesRepository
     */
    public function __construct(QuestionCategoriesRepository $questionCategoriesRepository)
    {
        $this->questionCategoriesRepository = $questionCategoriesRepository;
    }

    /**
     * Display a listing of the question category.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view($this->viewsPath . 'index');
    }

    public function create()
    {
        /*if (! Gate::allows('create insurance company'))
            abort(403);*/

        return view($this->viewsPath.'create');
    }

    /**
     * Store a newly created question category in storage.
     *
     * @param QuestionCategoryStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(QuestionCategoryStoreRequest $request): RedirectResponse
    {
        # check if repository not create question category return alert.
        if( !$this->questionCategoriesRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.field_process'))->withInput();

        return redirect()->route('admin.questions-category.index')->with(['success' => 'Updated Successfully']);
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
     * Store a newly created question category in storage.
     *
     * @param QuestionCategory $questions_category
     *
     * @return Application|Factory|\Illuminate\View\View
     */
    public function edit(QuestionCategory $questions_category)
    {
        /*if (! Gate::allows('edit insurance company'))
            abort(403);*/

        return view($this->viewsPath.'edit', compact('questions_category'));
    }

    /**
     * Update the specified question category in storage.
     *
     * * @param QuestionCategoryUpdateRequest $request
     * @param QuestionCategory $questions_category
     *
     * @return RedirectResponse
     */
    public function update(QuestionCategoryUpdateRequest $request, QuestionCategory $questions_category): RedirectResponse
    {
        # check if repository not update question category return alert.
        if( !$this->questionCategoriesRepository->update($questions_category, $request->except('_token', '_method')) )
            return redirect()->back()->with('failed', __('messages.field_process'));

        return redirect()->route('admin.questions-category.index')->with(['success' => 'Updated Successfully']);
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
