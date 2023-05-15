<?php

namespace Modules\SubscriptionForm\Controllers\Web;


use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\SubscriptionForm\Http\Requests\SubscriptionFormRequest;
use Modules\SubscriptionForm\Repositories\SubscriptionFormRepository;

class SubscriptionFormController extends Controller
{
    protected $subscriptionFormRepository;

    /**
     * SubscriptionFormRepository
     *
     * @param SubscriptionFormRepository $subscriptionFormRepository
     */
    public function __construct(SubscriptionFormRepository $subscriptionFormRepository)
    {
        $this->subscriptionFormRepository = $subscriptionFormRepository;
    }

    /**
     * Store a newly created subscription in storage.
     *
     * @param SubscriptionFormRequest $request
     *
     * @return RedirectResponse
     */
    public function store(SubscriptionFormRequest $request): RedirectResponse
    {
        # check if repository not create subscription return alert.
        if( !$this->subscriptionFormRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.field_process'))->withInput();

        return redirect('/')->with(['success' => 'Updated Successfully']);
    }
}
