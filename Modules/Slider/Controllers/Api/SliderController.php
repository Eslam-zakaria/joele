<?php

namespace Modules\Slider\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\Slider\Models\Slider;
use Illuminate\Http\Request;
use Modules\Slider\Repositories\SlidersRepository;

class SliderController extends Controller
{
    private $slidersRepository;

    /**
     * BlogCategoryController constructor.
     *
     * @param SlidersRepository $slidersRepository
     */
    public function __construct(SlidersRepository $slidersRepository)
    {
        $this->slidersRepository = $slidersRepository;
    }

    public function index(Request $request)
    {
            $sliders = Slider::query()
                ->select('sliders.*')
                ->when($request->get('q'), function (Builder $query) {
                    $word = request()->get('q');
                    $query->join('slider_translations', function (JoinClause $join) {
                        $join->on('slider_translations.slider_id', '=', 'sliders.id');
                    })->where('slider_translations.locale','ar');

                    return $query->whereRaw("(slider_translations.first_title like '%{$word}%') or sliders.id = '%{$word}%'");
                })

                ->orderBy(request()->get('sort', 'sliders.created_at'), request()->get('direction', 'DESC'))
                ->orderBy('sliders.id', request()->get('direction', 'DESC'))
                ->paginate(10);

        return response()->json($sliders);
    }

    /**
     * Update status.
     *
     * @param Slider $slider
     *
     * @return JsonResponse
     */
    public function changeStatus(Slider $slider): JsonResponse
    {
        if (! Gate::allows('edit slider')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( !$this->slidersRepository->update($slider, ['status' => ($slider->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $slider,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified slider from storage.
     *
     * @param Slider $slider
     *
     * @return JsonResponse
     */
    public function destroy(Slider $slider): JsonResponse
    {
        if (! Gate::allows('delete slider')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        # check if repository not delete slider return alert.
        if( !$this->slidersRepository->delete($slider) ){
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
