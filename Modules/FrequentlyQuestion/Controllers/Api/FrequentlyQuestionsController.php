<?php

namespace Modules\FrequentlyQuestion\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\FrequentlyQuestion\Models\FrequentlyQuestion;
use Modules\FrequentlyQuestion\Repositories\FrequentlyQuestionRepository;
use Modules\InsuranceCompany\Models\InsuranceCompany;
use Illuminate\Http\Request;

class FrequentlyQuestionsController extends Controller
{
    private $frequentlyQuestionRepository;

    /**
     * InsuranceCompanyRepository constructor.
     *
     * @param FrequentlyQuestionRepository $frequentlyQuestionRepository
     */
    public function __construct(FrequentlyQuestionRepository $frequentlyQuestionRepository)
    {
        $this->frequentlyQuestionRepository = $frequentlyQuestionRepository;
    }

    public function index(Request $request)
    {
        return $this->frequentlyQuestionRepository->get($request->all());
    }

    /**
     * Update status.
     *
     * @param FrequentlyQuestion $frequentlyQuestion
     *
     * @return JsonResponse
     */
    public function changeStatus(FrequentlyQuestion $frequentlyQuestion): JsonResponse
    {
        if (! Gate::allows('edit frequently question')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( !$this->frequentlyQuestionRepository->update($frequentlyQuestion, ['status' => ($frequentlyQuestion->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $frequentlyQuestion,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified insurance company from storage.
     *
     * @param FrequentlyQuestion $frequentlyQuestion
     *
     * @return JsonResponse
     */
    public function destroy(FrequentlyQuestion $frequentlyQuestion): JsonResponse
    {
        if (! Gate::allows('delete frequently question')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        # check if repository not delete insurance company return alert.
        if( !$this->frequentlyQuestionRepository->delete($frequentlyQuestion) ){
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
