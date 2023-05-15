<?php

namespace Modules\Review\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Modules\Review\Http\Requests\ReviewQuestionStoreRequest;
use Modules\Review\Http\Requests\ReviewQuestionUpdateRequest;
use Modules\Review\Models\ReviewQuestion;
use Modules\Review\Repositories\ReviewQuestionsRepository;

class ReviewQuestionsController extends Controller
{
    private $reviewQuestionsRepository;
    private $viewsPath = 'Review.Resources.views.questions.';

    /**
     * ReviewQuestionsController constructor.
     *
     * @param ReviewQuestionsRepository $reviewQuestionsRepository
     */
    public function __construct(ReviewQuestionsRepository $reviewQuestionsRepository)
    {
        $this->reviewQuestionsRepository = $reviewQuestionsRepository;
    }

    /**
     * Display a listing of the review questions.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list review questions'))
            abort(403);

        return view("$this->viewsPath.index");
    }

    /**
     * Show the form for creating a new review question.
     *
     * @return Application|Factory|RedirectResponse|\Illuminate\View\View
     */
    public function create()
    {
        if (! Gate::allows('create review question'))
            abort(403);

        if( ReviewQuestion::count() >= 5 )
            return redirect()->route('admin.reviews-questions.index')->with('danger', 'لا يمكن اضافة اكثر من 5 اسالة');

        return view("$this->viewsPath.create");
    }

    /**
     * Store a newly created review question in storage.
     *
     * @param ReviewQuestionStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ReviewQuestionStoreRequest $request): RedirectResponse
    {
        # check if repository not create review question return alert.
        if( !$this->reviewQuestionsRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('admin.reviews-questions.index')->with('success', __('messages.response.created'));
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
     * Show the form for editing the specified review question.
     *
     * @param ReviewQuestion $reviewQuestion
     *
     * @return Application|Factory|View
     */
    public function edit(ReviewQuestion $reviews_question)
    {
        if (! Gate::allows('edit review question'))
            abort(403);

        return view("$this->viewsPath.edit", compact('reviews_question'));
    }

    /**
     * Update the specified review question in storage.
     *
     * @param ReviewQuestionUpdateRequest $request
     * @param ReviewQuestion $reviews_question
     *
     * @return RedirectResponse
     */
    public function update(ReviewQuestionUpdateRequest $request, ReviewQuestion $reviews_question): RedirectResponse
    {
        # check if repository not update review question return alert.
        if( !$this->reviewQuestionsRepository->update( $reviews_question, $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.response.field_process'));

        return redirect()->route('admin.reviews-questions.index')->with('success', __('messages.response.updated'));
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
