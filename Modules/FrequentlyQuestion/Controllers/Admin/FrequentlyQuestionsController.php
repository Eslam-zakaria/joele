<?php

namespace Modules\FrequentlyQuestion\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Modules\FrequentlyQuestion\Http\Requests\FrequentlyQuestionStoreRequest;
use Modules\FrequentlyQuestion\Http\Requests\FrequentlyQuestionUpdateRequest;
use Modules\FrequentlyQuestion\Models\FrequentlyQuestion;
use Modules\FrequentlyQuestion\Repositories\FrequentlyQuestionRepository;
use Modules\FrequentlyQuestion\Repositories\QuestionCategoriesRepository;
use Modules\InsuranceCompany\Http\Requests\InsuranceCompanyStoreRequest;
use Modules\InsuranceCompany\Http\Requests\InsuranceCompanyUpdateRequest;

class FrequentlyQuestionsController extends Controller
{
    private $frequentlyQuestionRepository;
    private $viewsPath = 'FrequentlyQuestion.Resources.views.';

    /**
     * FrequentlyQuestionsController constructor.
     *
     * @param FrequentlyQuestionRepository $frequentlyQuestionRepository
     * @param QuestionCategoriesRepository $questionCategoriesRepository
     */
    public function __construct(FrequentlyQuestionRepository $frequentlyQuestionRepository, QuestionCategoriesRepository $questionCategoriesRepository)
    {
        $this->frequentlyQuestionRepository = $frequentlyQuestionRepository;
        $this->questionCategoriesRepository = $questionCategoriesRepository;
    }

    /**
     * Display a listing of the insurance companies.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list frequently questions'))
            abort(403);

        return view($this->viewsPath . 'index');
    }

    /**
     * Get form to add new question.
     *
     * @return Application|Factory|\Illuminate\View\View
     */
    public function create()
    {
        if (! Gate::allows('create frequently question'))
            abort(403);

        # Repository to list categories.
        $categories = $this->questionCategoriesRepository->list();

        return view("$this->viewsPath.create", compact('categories'));
    }

    /**
     * Store a newly created frequently question in storage.
     *
     * @param FrequentlyQuestionStoreRequest.php $request
     *
     * @return RedirectResponse
     */
    public function store(FrequentlyQuestionStoreRequest $request): RedirectResponse
    {
        # check if repository not create frequently question return alert.
        if( !$this->frequentlyQuestionRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.field_process'))->withInput();

        return redirect()->route('admin.frequently-questions.index')->with(['success' => 'Updated Successfully']);
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
     * Store a newly created frequently question in storage.
     *
     * @param FrequentlyQuestion $frequentlyQuestion
     *
     * @return Application|Factory|\Illuminate\View\View
     */
    public function edit(FrequentlyQuestion $frequentlyQuestion)
    {
        if (! Gate::allows('edit frequently question'))
            abort(403);

        # Repository to list categories.
        $categories = $this->questionCategoriesRepository->list();

        return view($this->viewsPath.'edit', compact('frequentlyQuestion', 'categories'));
    }

    /**
     * Update the specified frequently question in storage.
     *
     * @param FrequentlyQuestionUpdateRequest $request
     * @param FrequentlyQuestion $frequentlyQuestion
     *
     * @return RedirectResponse
     */
    public function update(FrequentlyQuestionUpdateRequest $request, FrequentlyQuestion $frequentlyQuestion): RedirectResponse
    {
        # check if repository not update frequently question return alert.
        if( !$this->frequentlyQuestionRepository->update($frequentlyQuestion, $request->except('_token', '_method')) )
            return redirect()->back()->with('failed', __('messages.field_process'));

        return redirect()->route('admin.frequently-questions.index')->with(['success' => 'Updated Successfully']);
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
     * Replicate specified frequently question.
     *
     * @param FrequentlyQuestion $frequentlyQuestion
     *
     * @return RedirectResponse
     */
    public function replicate(FrequentlyQuestion $frequentlyQuestion): RedirectResponse
    {
        # check if repository not replicate frequently question return alert.
        if( !$this->frequentlyQuestionRepository->replicate($frequentlyQuestion) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('admin.frequently-questions.index')->with('success', __('messages.response.created'));
    }
}

