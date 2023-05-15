<?php

namespace Modules\Redirection\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Redirection\Http\Requests\RedirectionStoreRequest;
use Modules\Redirection\Http\Requests\RedirectionUpdateRequest;
use Modules\Redirection\Models\Redirection;
use Modules\Redirection\Repositories\RedirectionRepository;
use Illuminate\Support\Facades\Gate;

class RedirectionsController extends Controller
{
    private $redirectionRepository;
    private $viewsPath = 'Redirection.Resources.views';

    /**
     * RedirectionsController constructor.
     *
     * @param RedirectionRepository $redirectionRepository
     */
    public function __construct(RedirectionRepository $redirectionRepository)
    {
        $this->redirectionRepository = $redirectionRepository;
    }

    /**
     * Display a listing of the redirection.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list redirections urls'))
            abort(403);

        return view("$this->viewsPath.index");
    }

    /**
     * Show the form for creating a new redirection.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        if (! Gate::allows('create redirections url'))
            abort(403);

        return view("$this->viewsPath.create");
    }

    /**
     * Store a newly created redirection in storage.
     *
     * @param RedirectionStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(RedirectionStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['from'] = trim(urldecode(str_replace(config('app.url') . '/', '', $data['from'])), '/');
        $data['to'] = trim(urldecode(str_replace(config('app.url') . '/', '', $data['to'])), '/');

        # check if repository not create redirection return alert.
        if( !$this->redirectionRepository->create($data) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('admin.redirections.index')->with('success', __('messages.response.created'));
    }

    /**
     * Show the form for editing the specified redirection.
     *
     * @param Redirection $redirection
     *
     * @return Application|Factory|View
     */
    public function edit(Redirection $redirection)
    {
        if (! Gate::allows('edit redirections url'))
            abort(403);

        return view("$this->viewsPath.edit", compact('redirection'));
    }

    /**
     * Update the specified redirection in storage.
     *
     * @param RedirectionUpdateRequest $request
     * @param Redirection $redirection
     *
     * @return RedirectResponse
     */
    public function update(RedirectionUpdateRequest $request, Redirection $redirection): RedirectResponse
    {
        $data = $request->validated();

        $data['from'] = trim(urldecode(str_replace(config('app.url') . '/', '', $data['from'])), '/');
        $data['to'] = trim(urldecode(str_replace(config('app.url') . '/', '', $data['to'])), '/');

        # check if repository not update redirection return alert.
        if( !$this->redirectionRepository->update( $redirection, $data ) )
            return redirect()->back()->with('failed', __('messages.response.field_process'));

        return redirect()->route('admin.redirections.index')->with('success', __('messages.response.updated'));
    }


}

