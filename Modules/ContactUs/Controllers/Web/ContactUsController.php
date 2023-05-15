<?php

namespace Modules\ContactUs\Controllers\Web;

use App\Enums\GeneralEnums;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\ContactUs\Http\Requests\ContactUsStoreRequest;
use Modules\ContactUs\Repositories\ContactUsRepository;

class ContactUsController extends Controller
{
    private $contactUsRepository;
    private $viewsPath = 'ContactUs.Resources.views.';

    /**
     * ContactUsController constructor.
     *
     * @param ContactUsRepository $contactUsRepository
     */
    public function __construct(ContactUsRepository $contactUsRepository)
    {
        $this->contactUsRepository = $contactUsRepository;
    }

    /**
     * Show the form for creating a new contact us.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        # Enum to get contact us.
        $contact_us_topic = GeneralEnums::Contact_Us_Topic;

        return view("$this->viewsPath.web.index", compact('contact_us_topic'));
    }

    /**
     * Store a newly created contact us in storage.
     *
     * @param ContactUsStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ContactUsStoreRequest $request): RedirectResponse
    {
        # check if repository not create contact us return alert.
        if( !$this->contactUsRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('contact-us.index')->with('success', __('messages.response.thanks_contact_us'));
    }
}
