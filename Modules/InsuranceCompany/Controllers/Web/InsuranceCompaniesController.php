<?php

namespace Modules\InsuranceCompany\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
        # Repository to list insurance companies.
        $insuranceCompanies = $this->insuranceCompanyRepository->list();

        return view($this->viewsPath . 'web.index', compact('insuranceCompanies'));
    }
}
