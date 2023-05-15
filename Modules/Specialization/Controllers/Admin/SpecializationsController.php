<?php

namespace Modules\Specialization\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Modules\Category\Repositories\CategoriesRepository;
use Modules\Specialization\Models\Specialization;
use Modules\Specialization\Repositories\SpecializationsRepository;
use Modules\Specialization\Http\Requests\SpecializationStoreRequest;
use Modules\Specialization\Http\Requests\SpecializationUpdateRequest;

class SpecializationsController extends Controller
{
    private $specializationRepository;
    private $viewsPath = 'Specialization.Resources.views.';

    /**
     * SpecializationController constructor.
     *
     * @param SpecializationsRepository $specializationRepository
     * @param CategoriesRepository $categoriesRepository
     */
    public function __construct(SpecializationsRepository $specializationRepository, CategoriesRepository $categoriesRepository)
    {
        $this->specializationRepository = $specializationRepository;
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * Display a listing of the specialization.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list doctors'))
            abort(403);

        return view($this->viewsPath.'index');
    }

    /**
     * Show the form for creating a new specialization.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        if (! Gate::allows('create doctor'))
            abort(403);

        # Repository list active doctors by assign display model.
        $categories = $this->categoriesRepository->list('doctors');

        return view($this->viewsPath.'create', compact('categories'));
    }

    /**
     * Store a newly created specialization in storage.
     *
     * @param SpecializationStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(SpecializationStoreRequest $request): RedirectResponse
    {
        # check if repository not create specialization return alert.
        if( !$this->specializationRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.field_process'))->withInput();

        return redirect()->route('admin.specializations.index')->with(['success' => 'Updated Successfully']);
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
     * Show the form for editing the specified specialization.
     *
     * @param Specialization $specialization
     *
     * @return Application|Factory|View
     */
    public function edit(Specialization $specialization)
    {
        if (! Gate::allows('edit doctor'))
            abort(403);

        # Repository list active doctors by assign display model.
        $categories = $this->categoriesRepository->list('doctors');

        return view($this->viewsPath.'edit', compact('specialization','categories'));
    }

    /**
     * Update the specified specialization in storage.
     *
     * @param SpecializationUpdateRequest $request
     * @param Specialization $specialization
     *
     * @return RedirectResponse
     */
    public function update(SpecializationUpdateRequest $request, Specialization $specialization): RedirectResponse
    {
        # check if repository not update specialization return alert.
        if( !$this->specializationRepository->update( $specialization, $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.field_process'));

        return redirect()->route('admin.specializations.index')->with('success', 'Updated Successfully');
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

