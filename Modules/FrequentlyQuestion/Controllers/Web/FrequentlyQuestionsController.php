<?php

namespace Modules\FrequentlyQuestion\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\FrequentlyQuestion\Repositories\FrequentlyQuestionRepository;
use Modules\FrequentlyQuestion\Repositories\QuestionCategoriesRepository;

class FrequentlyQuestionsController extends Controller
{

    private $frequentlyQuestionRepository;
    private $questionCategoriesRepository;
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
        # Repository to list questions.
        $questions = $this->frequentlyQuestionRepository->list();

        # Repository to list categories.
        $categories = $this->questionCategoriesRepository->list();

        return view($this->viewsPath . 'web.index', compact('categories', 'questions'));
    }
}
