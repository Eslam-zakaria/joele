<?php

namespace Modules\FrequentlyQuestion\Controllers\Api;

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
use Modules\FrequentlyQuestion\Http\Requests\QuestionCategoryStoreRequest;
use Modules\FrequentlyQuestion\Http\Requests\QuestionCategoryUpdateRequest;
use Modules\FrequentlyQuestion\Models\QuestionCategory;
use Modules\FrequentlyQuestion\Repositories\QuestionCategoriesRepository;

class QuestionsCategoryController extends controller
{
    private $questionCategoriesRepository;

    /**
     * QuestionsCategoryController constructor.
     *
     * @param QuestionCategoriesRepository $questionCategoriesRepository
     */
    public function __construct(QuestionCategoriesRepository $questionCategoriesRepository)
    {
        $this->questionCategoriesRepository = $questionCategoriesRepository;
    }

    /**
     * List questions categories data.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\phpDocumentor\Reflection\Types\Collection
     */
    public function index(Request $request)
    {
        return $this->questionCategoriesRepository->get($request->all());
    }

    /**
     * Update status.
     *
     * @param QuestionCategory $question_category
     *
     * @return JsonResponse
     */
    public function changeStatus(QuestionCategory $question_category): JsonResponse
    {
        if (! Gate::allows('edit frequently question')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( !$this->questionCategoriesRepository->update($question_category, ['status' => ($question_category->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $question_category,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified insurance company from storage.
     *
     * @param QuestionCategory $question_category
     *
     * @return JsonResponse
     */
    public function destroy(QuestionCategory $question_category): JsonResponse
    {
        if (! Gate::allows('delete frequently question')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        # check if repository not delete insurance company return alert.
        if( !$this->questionCategoriesRepository->delete($question_category) ){
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
