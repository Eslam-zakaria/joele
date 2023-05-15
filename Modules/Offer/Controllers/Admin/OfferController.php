<?php

namespace Modules\Offer\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Modules\Category\Repositories\CategoriesRepository;
use Modules\Offer\Http\Requests\OfferStoreRequest;
use Modules\Offer\Models\Offer;
use Modules\Offer\Http\Requests\OfferUpdateRequest;
use Modules\Offer\Repositories\OffersRepository;

class OfferController extends Controller
{
    private $offersRepository;
    private $categoriesRepository;
    private $viewsPath = 'Offer.Resources.views.';

    /**
     * OfferController constructor.
     *
     * @param OffersRepository $offersRepository
     * @param CategoriesRepository $categoriesRepository
     */
    public function __construct(OffersRepository $offersRepository, CategoriesRepository $categoriesRepository)
    {
        $this->offersRepository = $offersRepository;
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * Display a listing of the offers.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list offers'))
            abort(403);

        return view($this->viewsPath.'index');
    }

    /**
     * Show the form for creating a new offer.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        if (! Gate::allows('create offer'))
            abort(403);

        # Repository list active categories by assign display model.
        $categories = $this->categoriesRepository->list('offers', ['branches']);

        return view("$this->viewsPath.create", compact('categories'));
    }

    /**
     * Store a newly created offer in storage.
     *
     * @param OfferStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(OfferStoreRequest $request): RedirectResponse
    {
        # check if repository not create offer return alert.
        if( !$this->offersRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('admin.offers.index')->with('success', __('messages.response.created'));
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
     * Show the form for editing the specified offer.
     *
     * @param Offer $offer
     *
     * @return Application|Factory|View
     */
    public function edit(Offer $offer)
    {
        if (! Gate::allows('edit offer'))
            abort(403);

        # Repository list active categories by assign display model.
        $categories = $this->categoriesRepository->list('offers', ['branches']);

        return view("$this->viewsPath.edit", compact('offer', 'categories'));
    }

    /**
     * Update the specified offer in storage.
     *
     * @param OfferUpdateRequest $request
     * @param Offer $offer
     *
     * @return RedirectResponse
     */
    public function update(OfferUpdateRequest $request, Offer $offer): RedirectResponse
    {
        # check if repository not update offer return alert.
        if( !$this->offersRepository->update( $offer, $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.response.field_process'));

        return redirect()->route('admin.offers.index')->with('success', __('messages.response.updated'));
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
     * Replicate specified offer
     *
     * @param Offer $offer
     *
     * @return RedirectResponse
     */
    public function replicate(Offer $offer): RedirectResponse
    {
        # check if repository not replicate offer return alert.
        if( !$this->offersRepository->replicate($offer) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('admin.offers.index')->with('success', __('messages.response.created'));
    }
}

