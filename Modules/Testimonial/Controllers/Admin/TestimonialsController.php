<?php

namespace Modules\Testimonial\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Modules\Testimonial\Repositories\TestimonialsRepository;
use Modules\Testimonial\Models\Testimonial;
use Modules\Testimonial\Http\Requests\TestimonialStoreRequest;
use Modules\Testimonial\Http\Requests\TestimonialUpdateRequest;

class TestimonialsController extends Controller
{
    private $testimonialsRepository;
    private $viewsPath = 'Testimonial.Resources.views.';

    /**
     * TestimonialsController constructor.
     *
     * @param TestimonialsRepository $testimonialsRepository
     */
    public function __construct(TestimonialsRepository $testimonialsRepository)
    {
        $this->testimonialsRepository = $testimonialsRepository;
    }

    /**
     * Display a listing of the testimonials.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list testimonials'))
            abort(403);

        return view($this->viewsPath.'index');
    }

    /**
     * Show the form for creating a new testimonial.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        if (! Gate::allows('create testimonial'))
            abort(403);

        return view($this->viewsPath.'create');
    }

    /**
     * Store a newly created testimonial in storage.
     *
     * @param TestimonialStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(TestimonialStoreRequest $request): RedirectResponse
    {
        # check if repository not create testimonial return alert.
        if( !$this->testimonialsRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.field_process'))->withInput();

        return redirect()->route('admin.testimonials.index')->with(['success' => 'Updated Successfully']);
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
     * Show the form for editing the specified testimonial.
     *
     * @param Testimonial $testimonial
     *
     * @return Application|Factory|View
     */
    public function edit(Testimonial $testimonial)
    {
        if (! Gate::allows('edit testimonial'))
            abort(403);

        return view($this->viewsPath.'edit', compact('testimonial'));
    }

    /**
     * Update the specified testimonial in storage.
     *
     * @param TestimonialUpdateRequest $request
     * @param Testimonial $testimonial
     *
     * @return RedirectResponse
     */
    public function update(TestimonialUpdateRequest $request, Testimonial $testimonial): RedirectResponse
    {
        # check if repository not update testimonial return alert.
        if( !$this->testimonialsRepository->update( $testimonial, $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.field_process'));

        return redirect()->route('admin.testimonials.index')->with(['success' => 'Updated Successfully']);
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

