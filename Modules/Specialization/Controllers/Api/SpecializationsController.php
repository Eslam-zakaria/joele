<?php

namespace Modules\Specialization\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\Specialization\Models\Specialization;
use Illuminate\Http\Request;
use Modules\Specialization\Repositories\SpecializationsRepository;

class SpecializationsController extends Controller
{
    private $specializationsRepository;

    /**
     * SpecializationsController constructor.
     *
     * @param SpecializationsRepository $specializationsRepository
     */
    public function __construct(SpecializationsRepository $specializationsRepository)
    {
        $this->specializationsRepository = $specializationsRepository;
    }

    /**
     * List specializations data from repository.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\phpDocumentor\Reflection\Types\Collection
     */
    public function index(Request $request)
    {
        return $this->specializationsRepository->get();
    }

    /**
     * Update status.
     *
     * @param Specialization $specialization
     *
     * @return JsonResponse
     */
    public function changeStatus(Specialization $specialization): JsonResponse
    {
        if (! Gate::allows('edit doctor')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( !$this->specializationsRepository->update($specialization, ['status' => ($specialization->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $specialization,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified specialization from storage.
     *
     * @param Specialization $specialization
     *
     * @return JsonResponse
     */
    public function destroy(Specialization $specialization): JsonResponse
    {
        if (! Gate::allows('delete doctor')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        # check if repository not delete specialization return alert.
        if( !$this->specializationsRepository->delete($specialization) ){
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
