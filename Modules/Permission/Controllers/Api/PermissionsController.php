<?php

namespace Modules\Permission\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Slider\Models\Slider;
use Illuminate\Http\Request;
use Modules\Permission\Repositories\PermissionsRepository;

class PermissionsController extends Controller
{
    private $permissionsRepository;

    /**
     * BlogCategoryController constructor.
     *
     * @param PermissionsRepository $permissionsRepository
     */
    public function __construct(PermissionsRepository $permissionsRepository)
    {
        $this->permissionsRepository = $permissionsRepository;
    }

    public function index(Request $request)
    {
            $sliders = Slider::query()
                ->select('sliders.*')
                ->orderBy(request()->get('sort', 'sliders.created_at'), request()->get('direction', 'DESC'))
                ->orderBy('sliders.id', request()->get('direction', 'DESC'))
                ->paginate(10);

        return response()->json($sliders);
    }
}
