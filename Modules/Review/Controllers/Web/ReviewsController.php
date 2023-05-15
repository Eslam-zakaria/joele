<?php

namespace Modules\Review\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Branch\Repositories\BranchesRepository;
use Modules\Doctor\Repositories\DoctorsRepository;
use Modules\Review\Http\Requests\ReviewStoreRequest;
use Modules\Review\Models\Review;
use Modules\Review\Repositories\ReviewQuestionsRepository;
use Modules\Review\Repositories\ReviewsRepository;

class ReviewsController extends Controller
{
    private $viewsPath = 'Review.Resources.views.';
    private $reviewQuestionsRepository;
    private $reviewsRepository;

    /**
     * ReviewsController constructor.
     *
     * @param ReviewQuestionsRepository $reviewQuestionsRepository
     * @param ReviewsRepository $reviewsRepository
     */
    public function __construct(ReviewsRepository $reviewsRepository, ReviewQuestionsRepository $reviewQuestionsRepository)
    {
        $this->reviewsRepository = $reviewsRepository;
        $this->reviewQuestionsRepository = $reviewQuestionsRepository;
    }

    /**
     * Show the form for creating a new review.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        # Repository to list reviews questions.
        $questions = $this->reviewQuestionsRepository->list();

        # Repository to list branches.
        $branches = app(BranchesRepository::class)->list(['listDoctors', 'translation']);

        return view("$this->viewsPath.web.index", compact('questions', 'branches'));
    }

    /**
     * Store a newly created review in storage.
     *
     * @param ReviewStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ReviewStoreRequest $request): RedirectResponse
    {
        # check if repository not create review return alert.
        if( !$this->reviewsRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('web.reviews.create')->with('success', __('messages.response.created'));
    }
}
