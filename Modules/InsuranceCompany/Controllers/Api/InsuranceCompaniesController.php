<?php

namespace Modules\InsuranceCompany\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\InsuranceCompany\Models\InsuranceCompany;
use Illuminate\Http\Request;
use Modules\InsuranceCompany\Repositories\InsuranceCompanyRepository;
use Modules\Slider\Models\Slider;

class InsuranceCompaniesController extends Controller
{
    private $insuranceCompanyRepository;

    /**
     * InsuranceCompanyRepository constructor.
     *
     * @param InsuranceCompanyRepository $insuranceCompanyRepository
     */
    public function __construct(InsuranceCompanyRepository $insuranceCompanyRepository)
    {
        $this->insuranceCompanyRepository = $insuranceCompanyRepository;
    }

    public function index(Request $request)
    {
            $insuranceCompanies = InsuranceCompany::query()
                ->select('insurance_companies.*')
                ->when($request->get('q'), function (Builder $query) {
                    $word = request()->get('q');
                    $query->join('insurance_company_translations', function (JoinClause $join) {
                        $join->on('insurance_company_translations.insurance_company_id', '=', 'insurance_companies.id');
                    })->where('insurance_company_translations.locale','ar');

                    return $query->whereRaw("(insurance_company_translations.title like '%{$word}%') or insurance_companies.id = '%{$word}%'");
                })

                ->orderBy(request()->get('sort', 'insurance_companies.created_at'), request()->get('direction', 'DESC'))
                ->orderBy('insurance_companies.id', request()->get('direction', 'DESC'))
                ->paginate(10);

        return response()->json($insuranceCompanies);
    }

    /**
     * Update status.
     *
     * @param InsuranceCompany $insuranceCompany
     *
     * @return JsonResponse
     */
    public function changeStatus(InsuranceCompany $insuranceCompany): JsonResponse
    {
        if (! Gate::allows('edit insurance company')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( !$this->insuranceCompanyRepository->update($insuranceCompany, ['status' => ($insuranceCompany->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $insuranceCompany,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified insurance company from storage.
     *
     * @param InsuranceCompany $insuranceCompany
     *
     * @return JsonResponse
     */
    public function destroy(InsuranceCompany $insuranceCompany): JsonResponse
    {
        if (! Gate::allows('delete insurance company')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        # check if repository not delete insurance company return alert.
        if( !$this->insuranceCompanyRepository->delete($insuranceCompany) ){
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'message'=> __('messages.response.deleted')
        ], Response::HTTP_OK); // Status code here
    }
}
