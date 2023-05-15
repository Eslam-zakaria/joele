<?php

namespace Modules\Redirection\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\Branch\Models\Branch;
use Illuminate\Http\Request;
use Modules\Branch\Repositories\BranchesRepository;
use Modules\Doctor\Repositories\DoctorsRepository;
use Modules\Redirection\Models\Redirection;
use Modules\Redirection\Repositories\RedirectionRepository;

class RedirectionsController extends Controller
{
    private $redirectionRepository;

    /**
     * RedirectionsController constructor.
     *
     * @param RedirectionRepository $redirectionRepository
     */
    public function __construct(RedirectionRepository $redirectionRepository)
    {
        $this->redirectionRepository = $redirectionRepository;
    }

    /**
     * Get collection of redirections.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\phpDocumentor\Reflection\Types\Collection
     */
    public function index(Request $request)
    {
        # Repository to collection fo redirections.
        return $this->redirectionRepository->get($request->all());
    }

    /**
     * Update status.
     *
     * @param Redirection $redirection
     *
     * @return JsonResponse
     */
    public function changeStatus(Redirection $redirection): JsonResponse
    {
        if (! Gate::allows('edit branch')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( !$this->redirectionRepository->update($redirection, ['status' => ($redirection->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $redirection,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified redirection from storage.
     *
     * @param Redirection $redirection
     *
     * @return JsonResponse
     */
    public function destroy(Redirection $redirection): JsonResponse
    {
        /*if (! Gate::allows('delete branch')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }*/

        # check if repository not delete redirection return alert.
        if( !$this->redirectionRepository->delete($redirection) ){
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
