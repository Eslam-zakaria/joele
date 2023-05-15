<?php

namespace Modules\Cases\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\Cases\Models\MedicalCase;
use Illuminate\Http\Request;
use Modules\Cases\Repositories\CasesRepository;

class CasesController extends Controller
{
    protected $casesRepository;
    /**
     * CasesController constructor.
     *
     * @param CasesRepository $casesRepository
     */
    public function __construct(CasesRepository $casesRepository)
    {
        $this->casesRepository = $casesRepository;
    }

    public function index(Request $request)
    {
        $users = MedicalCase::query()
            ->select('medical_cases.*')
            ->orderBy('medical_cases.'.request()->get('sort', 'created_at'), request()->get('direction', 'DESC'))
            ->orderBy('medical_cases.id', request()->get('direction', 'DESC'))
            ->with('doctor', 'branch')
            ->paginate(10);

        return response()->json($users);
    }

    /**
     * Update status.
     *
     * @param MedicalCase $case
     *
     * @return JsonResponse
     */
    public function changeStatus(MedicalCase $case): JsonResponse
    {
        if (! Gate::allows('edit case')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( !$this->casesRepository->update($case, ['status' => ($case->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $case,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified category from storage.
     *
     * @param MedicalCase $case
     *
     * @return JsonResponse
     */
    public function destroy(MedicalCase $case): JsonResponse
    {
        if (! Gate::allows('delete case')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        # check if repository not delete category return alert.
        if( !$this->casesRepository->delete($case) ){
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
