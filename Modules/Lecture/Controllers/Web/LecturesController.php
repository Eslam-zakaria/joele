<?php

namespace Modules\Lecture\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Category\Repositories\CategoriesRepository;
use Modules\Lecture\Repositories\LecturesRepository;

class LecturesController extends Controller
{
    private $lecturesRepository;
    private $categoriesRepository;
    private $viewsPath = 'Lecture.Resources.views.';

    /**
     * LecturesController constructor.
     *
     * @param LecturesRepository $lecturesRepository
     * @param CategoriesRepository $categoriesRepository
     */
    public function __construct(LecturesRepository $lecturesRepository, CategoriesRepository $categoriesRepository)
    {
        $this->lecturesRepository = $lecturesRepository;
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * Display a listing of the lectures.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        # Repository to list lectures.
        $lectures = $this->lecturesRepository->list($request->all());

        # Repository to list categories.
        $categories = $this->categoriesRepository->list('lectures', ['translation']);

        return view($this->viewsPath.'web.index', compact('lectures', 'categories'));
    }
}
