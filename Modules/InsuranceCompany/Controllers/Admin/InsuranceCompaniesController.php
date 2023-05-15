<?php

namespace Modules\InsuranceCompany\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Modules\InsuranceCompany\Models\InsuranceCompany;
use Modules\InsuranceCompany\Http\Requests\InsuranceCompanyStoreRequest;
use Modules\InsuranceCompany\Http\Requests\InsuranceCompanyUpdateRequest;
use Modules\InsuranceCompany\Repositories\InsuranceCompanyRepository;

class InsuranceCompaniesController extends Controller
{
    private $insuranceCompanyRepository;
    private $viewsPath = 'InsuranceCompany.Resources.views.';

    /**
     * InsuranceCompanyRepository constructor.
     *
     * @param InsuranceCompanyRepository $insuranceCompanyRepository
     */
    public function __construct(InsuranceCompanyRepository $insuranceCompanyRepository)
    {
        $this->insuranceCompanyRepository = $insuranceCompanyRepository;
    }

    /**
     * Display a listing of the insurance companies.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list insurance companies'))
            abort(403);

        return view($this->viewsPath . 'index');
    }

    public function create()
    {
        if (! Gate::allows('create insurance company'))
            abort(403);

        return view($this->viewsPath.'create');
    }

    /**
     * Store a newly created insurance company in storage.
     *
     * @param InsuranceCompanyStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(InsuranceCompanyStoreRequest $request): RedirectResponse
    {
        # check if repository not create insurance company return alert.
        if( !$this->insuranceCompanyRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.field_process'))->withInput();

        return redirect()->route('admin.insurance-companies.index')->with(['success' => 'Updated Successfully']);
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
     * Store a newly created insurance company in storage.
     *
     * @param InsuranceCompany $insuranceCompany
     *
     * @return Application|Factory|\Illuminate\View\View
     */
    public function edit(InsuranceCompany $insuranceCompany)
    {
        if (! Gate::allows('edit insurance company'))
            abort(403);

        return view($this->viewsPath.'edit',['form' => $insuranceCompany]);
    }

    /**
     * Update the specified insurance company in storage.
     *
     * @param InsuranceCompany $insuranceCompany
     * @param InsuranceCompanyUpdateRequest $request
     *
     * @return RedirectResponse
     */
    public function update(InsuranceCompanyUpdateRequest $request, InsuranceCompany $insuranceCompany): RedirectResponse
    {
        # check if repository not update insurance company return alert.
        if( !$this->insuranceCompanyRepository->update($insuranceCompany, $request->except('_token', '_method')) )
            return redirect()->back()->with('failed', __('messages.field_process'));

        return redirect()->route('admin.insurance-companies.index')->with(['success' => 'Updated Successfully']);
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
     * Replicate specified insurance company.
     *
     * @param InsuranceCompany $insuranceCompany
     *
     * @return RedirectResponse
     */
    public function replicate(InsuranceCompany $insuranceCompany): RedirectResponse
    {
        # check if repository not replicate insurance company return alert.
        if( !$this->insuranceCompanyRepository->replicate($insuranceCompany) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('admin.insurance-companies.index')->with('success', __('messages.response.created'));
    }
}

