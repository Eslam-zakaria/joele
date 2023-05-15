<?php

namespace Modules\Slider\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Modules\Slider\Models\Slider;
use Modules\Slider\Repositories\SlidersRepository;
use Modules\Slider\Http\Requests\SliderStoreRequest;
use Modules\Slider\Http\Requests\SliderUpdateRequest;

class SliderController extends Controller
{
    private $slidersRepository;
    private $viewsPath = 'Slider.Resources.views.';

    /**
     * SliderController constructor.
     *
     * @param SlidersRepository $slidersRepository
     */
    public function __construct(SlidersRepository $slidersRepository)
    {
        $this->slidersRepository = $slidersRepository;
    }

    /**
     * Display a listing of the sliders.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list sliders'))
            abort(403);

        return view($this->viewsPath.'index');
    }

    /**
     * Show the form for creating a new slider.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        if (! Gate::allows('create slider'))
            abort(403);

        return view($this->viewsPath.'create');
    }

    /**
     * Store a newly created slider in storage.
     *
     * @param SliderStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(SliderStoreRequest $request): RedirectResponse
    {
        # check if repository not create slider return alert.
        if( !$this->slidersRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.field_process'))->withInput();

        return redirect()->route('admin.sliders.index')->with(['success' => 'Updated Successfully']);
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
     * Show the form for editing the specified slider.
     *
     * @param Slider $slider
     *
     * @return Application|Factory|View
     */
    public function edit(Slider $slider)
    {
        if (! Gate::allows('edit slider'))
            abort(403);

        return view($this->viewsPath.'edit', compact('slider'));
    }

    /**
     * Update the specified slider in storage.
     *
     * @param SliderUpdateRequest $request
     * @param Slider $slider
     *
     * @return RedirectResponse
     */
    public function update(SliderUpdateRequest $request, Slider $slider): RedirectResponse
    {
        # check if repository not update slider return alert.
        if( !$this->slidersRepository->update( $slider, $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.field_process'));

        return redirect()->route('admin.sliders.index')->with('success', 'Updated Successfully');
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
     * Replicate specified slider
     *
     * @param Slider $slider
     *
     * @return RedirectResponse
     */
    public function replicate(Slider $slider): RedirectResponse
    {
        # check if repository not replicate slider return alert.
        if( !$this->slidersRepository->replicate($slider) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('admin.sliders.index')->with('success', __('messages.response.created'));
    }
}

