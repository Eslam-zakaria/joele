<?php

namespace Modules\ContactUs\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Gate;
use Modules\ContactUs\Http\Requests\ContactUsUpdateRequest;
use Modules\ContactUs\Models\ContactUs;
use Modules\ContactUs\Repositories\ContactUsRepository;

class ContactUsController extends Controller
{
    protected $contactUsRepository;
    private $viewsPath = 'ContactUs.Resources.views.';

    /**
     * ContactUsRepository
     *
     * @param ContactUsRepository $contactUsRepository
     */
    public function __construct(ContactUsRepository $contactUsRepository)
    {
        $this->contactUsRepository = $contactUsRepository;
    }

    /**
     * Display a listing of the contact us.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list contact-us'))
            abort(403);

        return view($this->viewsPath.'index');
    }

    /**
     * Display the specified contact us.
     *
     * @param ContactUs $contact_u
     *
     * @return Application|Factory|RedirectResponse|\Illuminate\View\View
     */
    public function show(ContactUs $contact_u)
    {
        if (! Gate::allows('show contact-us'))
            abort(403);

        # check if repository not update contact us return alert.
        if( !$this->contactUsRepository->update( $contact_u, ['status' => 1]) )
            return redirect()->back()->with('failed', __('messages.response.failed'));

        return view($this->viewsPath . 'show', compact('contact_u'));
    }

    /**
     * Update the specified contact us in storage.
     *
     * @param ContactUsUpdateRequest $request
     * @param ContactUs $contact_u
     *
     * @return RedirectResponse
     */
    public function update(ContactUsUpdateRequest $request, ContactUs $contact_u): RedirectResponse
    {
        if (! Gate::allows('edit contact-us'))
            abort(403);

        # Check if repository not update contact us return alert.
        if( !$this->contactUsRepository->update( $contact_u, $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.response.failed'));

        return redirect()->route('admin.contact-us.show', $contact_u->id)->with('success', __('messages.response.deleted'));
    }

    /**
     * Remove the specified contact us from storage.
     *
     * @param ContactUs $contact_u
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(ContactUs $contact_u)
    {
        # delete contact us.
        if( !$this->contactUsRepository->delete($contact_u) )
            return redirect()->back()->with('failed', __('messages.response.failed'));

        return redirect()->route('admin.contact-us.index')->with('success', __('messages.response.deleted'));
    }
}
