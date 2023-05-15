<?php

namespace Modules\Lecture\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\Lecture\Models\Lecture;
use Modules\Lecture\Repositories\LecturesRepository;

class LecturesController extends Controller
{
    private $lecturesRepository;

    /**
     * LecturesController constructor.
     *
     * @param LecturesRepository $lecturesRepository
     */
    public function __construct(LecturesRepository $lecturesRepository)
    {
        $this->lecturesRepository = $lecturesRepository;
    }

    public function index(Request $request)
    {
        $users = Lecture::query()
            ->select('lectures.*')
            ->when($request->get('q'), function (Builder $query) {
                $word = request()->get('q');
                $query->join('lecture_translations', function (JoinClause $join) {
                    $join->on('lecture_translations.lecture_id', '=', 'lectures.id');
                })->where('lecture_translations.locale','ar');

                return $query->whereRaw("(lecture_translations.title like '%{$word}%') or lectures.id = '%{$word}%'");
            })
            ->orderBy('lectures.'.request()->get('sort', 'created_at'), request()->get('direction', 'DESC'))
            ->orderBy('lectures.id', request()->get('direction', 'DESC'))
            ->with('category')
            ->groupBy('lectures.id')
            ->paginate(10);

        return response()->json($users);
    }

    /**
     * Update status.
     *
     * @param Lecture $lecture
     *
     * @return JsonResponse
     */
    public function changeStatus(Lecture $lecture): JsonResponse
    {
        if (! Gate::allows('edit lecture')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( !$this->lecturesRepository->update($lecture, ['status' => ($lecture->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $lecture,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified lecture from storage.
     *
     * @param Lecture $lecture
     *
     * @return JsonResponse
     */
    public function destroy(Lecture $lecture): JsonResponse
    {
        if (! Gate::allows('delete lecture')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        # check if repository not delete lecture return alert.
        if( !$this->lecturesRepository->delete($lecture) ){
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
