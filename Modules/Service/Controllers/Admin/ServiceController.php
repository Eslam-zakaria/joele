<?php

namespace Modules\Service\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Modules\Category\Repositories\CategoriesRepository;
use Modules\FrequentlyQuestion\Models\FrequentlyQuestion;
use Modules\FrequentlyQuestion\Repositories\FrequentlyQuestionRepository;
use Modules\Service\Models\Service;
use Modules\Service\Http\Requests\ServiceStoreRequest;
use Modules\Service\Http\Requests\ServiceUpdateRequest;
use Modules\Service\Repositories\ServicesRepository;

class ServiceController extends Controller
{
    private $servicesRepository;
    private $categoriesRepository;
    private $viewsPath = 'Service.Resources.views.';

    /**
     * ServiceController constructor.
     *
     * @param ServicesRepository $servicesRepository
     * @param CategoriesRepository $categoriesRepository
     * @param FrequentlyQuestionRepository $frequentlyQuestionRepository
     */
    public function __construct(ServicesRepository $servicesRepository, CategoriesRepository $categoriesRepository ,FrequentlyQuestionRepository $frequentlyQuestionRepository)
    {
        $this->servicesRepository = $servicesRepository;
        $this->categoriesRepository = $categoriesRepository;
        $this->frequentlyQuestionRepository = $frequentlyQuestionRepository;
    }

    /**
     * Display a listing of the services.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list services'))
            abort(403);

        return view($this->viewsPath.'index');
    }

    /**
     * Show the form for creating a new service.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        if (! Gate::allows('create service'))
            abort(403);

        # Repository list active services by assign display model.
        $categories = $this->categoriesRepository->list('services');

        return view($this->viewsPath.'create', compact('categories'));
    }

    /**
     * Store a newly created service in storage.
     *
     * @param ServiceStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ServiceStoreRequest $request): RedirectResponse
    {
        # check if repository not create service return alert.
        if( !$this->servicesRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.field_process'))->withInput();

        return redirect()->route('admin.services.index')->with(['success' => 'Updated Successfully']);
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
     * Show the form for editing the specified service.
     *
     * @param Service $service
     *
     * @return Application|Factory|View
     */
    public function edit(Service $service)
    {
        if (! Gate::allows('edit service'))
            abort(403);

        # Repository list active services by assign display model.
        $categories = $this->categoriesRepository->list('services');

        # Repository list of $faq.
        $getQuestions  = $service->faqPage()->get();

        return view($this->viewsPath.'edit', compact('service', 'categories','getQuestions'));
    }

    /**
     * Update the specified service in storage.
     *
     * @param ServiceUpdateRequest $request
     * @param Service $service
     *
     * @return RedirectResponse
     */
    public function update(ServiceUpdateRequest $request, Service $service): RedirectResponse
    {
        # check if repository not update service return alert.
        if( !$this->servicesRepository->update( $service, $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.field_process'));

        if( isset($request['experienceEdit']) ){
            foreach ($request['experienceEdit'] as $experienceData) {
                $details = FrequentlyQuestion::findOrFail($experienceData['id']);
                $details->update($experienceData);
            }
        }

        return redirect()->route('admin.services.index')->with('success', 'Updated Successfully');
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
     * delete Row.
     * @param FrequentlyQuestion $question
     */
    public function deleteQuestion(FrequentlyQuestion $question)
    {

        $question->delete();

        return redirect()->back()->with('success', 'deleted successfully');
    }

    /**
     * Replicate specified service
     *
     * @param Service $service
     *
     * @return RedirectResponse
     */
    public function replicate(Service $service): RedirectResponse
    {
        # check if repository not replicate service return alert.
        if( !$this->servicesRepository->replicate($service) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('admin.services.index')->with('success', __('messages.response.created'));
    }
}

