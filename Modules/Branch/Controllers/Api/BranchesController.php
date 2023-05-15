<?php

namespace Modules\Branch\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\Branch\Models\Branch;
use Illuminate\Http\Request;
use Modules\Branch\Repositories\BranchesRepository;
use Modules\Doctor\Repositories\DoctorsRepository;

class BranchesController extends Controller
{
    private $branchesRepository;
    private $doctorsRepository;

    /**
     * BranchesController constructor.
     *
     * @param BranchesRepository $branchesRepository
     * @param DoctorsRepository $doctorsRepository
     */
    public function __construct(BranchesRepository $branchesRepository,DoctorsRepository $doctorsRepository)
    {
        $this->branchesRepository = $branchesRepository;
        $this->doctorsRepository    = $doctorsRepository;
    }

    /**
     * Get collection of branches.
     *
     * @uses \Modules\Branch\Repositories\BranchesRepository::list()
     *
     * @return \Illuminate\Support\Collection
     */
    public function list()
    {
        # Repository to collection fo branches.
        return $this->branchesRepository->list();
    }

    /**
     * Get collection with pagination of branches.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\phpDocumentor\Reflection\Types\Collection
     */
    public function get(Request $request)
    {
        # Repository to collection fo branches.
        return $this->branchesRepository->get($request->all());
    }

    /**
     * Update status.
     *
     * @param Branch $branch
     *
     * @return JsonResponse
     */
    public function changeStatus(Branch $branch): JsonResponse
    {
        if (! Gate::allows('edit branch')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( !$this->branchesRepository->update($branch, ['status' => ($branch->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $branch,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified category from storage.
     *
     * @param Branch $branch
     *
     * @return JsonResponse
     */
    public function destroy(Branch $branch): JsonResponse
    {
        if (! Gate::allows('delete branch')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        # check if repository not delete category return alert.
        if( !$this->branchesRepository->delete($branch) ){
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

    public function listDoctorsByBranch($branch,Request $request)
    {
        $doctors = $this->doctorsRepository->listDoctorsByBranch($branch);

        return response()->json(['doctors' => $doctors]);
    }
}
