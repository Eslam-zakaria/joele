<?php

namespace Modules\Review\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\Review\Http\Requests\ReviewQuestionStoreRequest;
use Modules\Review\Http\Requests\ReviewQuestionUpdateRequest;
use Modules\Review\Models\ReviewQuestion;
use Modules\Review\Repositories\ReviewQuestionsRepository;

class ReviewQuestionsController extends Controller
{
    private $reviewQuestionsRepository;

    /**
     * ReviewQuestionsController constructor.
     *
     * @param ReviewQuestionsRepository $reviewQuestionsRepository
     */
    public function __construct(ReviewQuestionsRepository $reviewQuestionsRepository)
    {
        $this->reviewQuestionsRepository = $reviewQuestionsRepository;
    }

    public function index(Request  $request)
    {
        return $this->reviewQuestionsRepository->list();
    }

    /**
     * Update status.
     *
     * @param ReviewQuestion $reviews_question
     *
     * @return JsonResponse
     */
    public function changeStatus(ReviewQuestion $review_question): JsonResponse
    {
        if (! Gate::allows('edit review question')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( !$this->reviewQuestionsRepository->update($review_question, ['status' => ($review_question->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $review_question,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified review question from storage.
     *
     * @param ReviewQuestion $reviews_question
     *
     * @return JsonResponse
     */
    public function destroy(ReviewQuestion $review_question): JsonResponse
    {
        if (! Gate::allows('delete review question')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        # check if repository not delete review question return alert.
        if( !$this->reviewQuestionsRepository->delete($review_question) ){
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
