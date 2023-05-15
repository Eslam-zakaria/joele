<?php

namespace Modules\Service\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\Service\Models\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Modules\Service\Repositories\ServicesRepository;

class ServiceController extends Controller
{
    private $servicesRepository;

    /**
     * ServiceController constructor.
     *
     * @param ServicesRepository $servicesRepository
     */
    public function __construct(ServicesRepository $servicesRepository)
    {
        $this->servicesRepository = $servicesRepository;
    }

    /**
     * Get list of services.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\phpDocumentor\Reflection\Types\Collection
     */
    public function index(Request $request)
    {
        return $this->servicesRepository->get($request->all());
    }

    /**
     * Get list of active services.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function active(Request $request)
    {
        return $this->servicesRepository->list();
    }

    /**
     * Update status.
     *
     * @param Service $service
     *
     * @return JsonResponse
     */
    public function changeStatus(Service $service): JsonResponse
    {
        if (! Gate::allows('edit service')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( !$this->servicesRepository->update($service, ['status' => ($service->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $service,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified category from storage.
     *
     * @param Service $service
     *
     * @return JsonResponse
     */
    public function destroy(Service $service): JsonResponse
    {
        if (! Gate::allows('delete service')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        # check if repository not delete category return alert.
        if( !$this->servicesRepository->delete($service) ){
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
