<?php

namespace Modules\Lecture\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Modules\Lecture\Http\Requests\LectureStoreRequest;
use Modules\Category\Repositories\CategoriesRepository;
use Modules\Lecture\Http\Requests\LectureUpdateRequest;
use Modules\Lecture\Models\Lecture;
use Modules\Lecture\Repositories\LecturesRepository;
use phpDocumentor\Reflection\Types\ArrayKey;

class LecturesController extends Controller
{
    private $lecturesRepository;
    private $categoriesRepository;
    private $viewsPath = 'Lecture.Resources.views.';

    /**
     * LecturesController constructor.
     *
     * @param CategoriesRepository $categoriesRepository
     * @param LecturesRepository $lecturesRepository
     */
    public function __construct(LecturesRepository $lecturesRepository, CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
        $this->lecturesRepository = $lecturesRepository;
    }

    /**
     * Display a listing of the lectures.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list lectures'))
            abort(403);

        return view("$this->viewsPath.index");
    }

    /**
     * Show the form for creating a new lecture.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        if (! Gate::allows('create lecture'))
            abort(403);

        # Repository list active categories by assign display model.
        $categories = $this->categoriesRepository->list('lectures');

        return view("$this->viewsPath.create", compact('categories'));
    }

    /**
     * Store a newly created lecture in storage.
     *
     * @param LectureStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(LectureStoreRequest $request): RedirectResponse
    {
        # check if repository not create lecture return alert.
        if( !$this->lecturesRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('admin.lectures.index')->with('success', __('messages.response.created'));
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
     * Show the form for editing the specified lecture.
     *
     * @param Lecture $lecture
     *
     * @return Application|Factory|View
     */
    public function edit(Lecture $lecture)
    {
        if (! Gate::allows('edit lecture'))
            abort(403);

        # Repository list active categories by assign display model.
        $categories = $this->categoriesRepository->list('lectures');

        return view("$this->viewsPath.edit", compact('lecture', 'categories'));
    }

    /**
     * Update the specified lecture in storage.
     *
     * @param LectureUpdateRequest $request
     * @param Lecture $lecture
     *
     * @return RedirectResponse
     */
    public function update(LectureUpdateRequest $request, Lecture $lecture): RedirectResponse
    {
        # check if repository not update lecture return alert.
        if( !$this->lecturesRepository->update( $lecture, $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.response.field_process'));

        return redirect()->route('admin.lectures.index')->with('success', __('messages.response.updated'));
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
     * Replicate specified lecture
     *
     * @param Lecture $lecture
     *
     * @return RedirectResponse
     */
    public function replicate(Lecture $lecture): RedirectResponse
    {
        # check if repository not replicate lecture return alert.
        if( !$this->lecturesRepository->replicate($lecture) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('admin.lectures.index')->with('success', __('messages.response.created'));
    }
}

