<?php

namespace Modules\Testimonial\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\Testimonial\Models\Testimonial;
use Illuminate\Http\Request;
use Modules\Testimonial\Repositories\TestimonialsRepository;

class TestimonialsController extends Controller
{
    private $testimonialsRepository;

    /**
     * TestimonialsController constructor.
     *
     * @param TestimonialsRepository $testimonialsRepository
     */
    public function __construct(TestimonialsRepository $testimonialsRepository)
    {
        $this->testimonialsRepository = $testimonialsRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $testimonials = Testimonial::query()
            ->select('testimonials.*')
            ->when($request->get('q'), function (Builder $query) {
                $word = request()->get('q');
                $query->join('testimonial_translations', function (JoinClause $join) {
                    $join->on('testimonial_translations.testimonial_id', '=', 'testimonials.id');
                });

                return $query->whereRaw("(testimonial_translations.name like '%{$word}%') or testimonials.id = '%{$word}%'");
            })
            ->orderBy(request()->get('sort', 'testimonials.created_at'), request()->get('direction', 'DESC'))
            ->orderBy('testimonials.id', request()->get('direction', 'DESC'))
            ->paginate(10);

        return response()->json($testimonials);
    }

    /**
     * Update status.
     *
     * @param Testimonial $testimonial
     *
     * @return JsonResponse
     */
    public function changeStatus(Testimonial $testimonial): JsonResponse
    {
        if (! Gate::allows('edit testimonial')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( !$this->testimonialsRepository->update($testimonial, ['status' => ($testimonial->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $testimonial,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified category from storage.
     *
     * @param Testimonial $testimonial
     *
     * @return JsonResponse
     */
    public function destroy(Testimonial $testimonial): JsonResponse
    {
        if (! Gate::allows('delete testimonial')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        # check if repository not delete category return alert.
        if( !$this->testimonialsRepository->delete($testimonial) ){
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
