<?php

namespace Modules\Category\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\Category\Models\Category;
use Illuminate\Http\Request;
use Modules\Category\Repositories\CategoriesRepository;

class CategoriesController extends Controller
{
    private $categoriesRepository;

    /**
     * CategoriesController constructor.
     *
     * @param CategoriesRepository $categoriesRepository
     */
    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    public function index(Request $request)
    {
        $categories = Category::query()
            ->select('categories.*')
            ->when($request->get('q'), function (Builder $query) {
                $word = request()->get('q');
                $query->join('category_translations', function (JoinClause $join) {
                    $join->on('category_translations.category_id', '=', 'categories.id');
                })->where('category_translations.locale','ar');

                return $query->whereRaw("(category_translations.name like '%{$word}%') or categories.id = '%{$word}%'");
            })
            ->orderBy(request()->get('sort', 'categories.created_at'), request()->get('direction', 'DESC'))
            ->orderBy('categories.id', request()->get('direction', 'DESC'))
            ->paginate(10);

        return response()->json($categories);
    }

    /**
     * Update status.
     *
     * @param Category $category
     *
     * @return JsonResponse
     */
    public function changeStatus(Category $category): JsonResponse
    {
        if (! Gate::allows('edit category')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( !$this->categoriesRepository->update($category, ['status' => ($category->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $category,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified category from storage.
     *
     * @param Category $category
     *
     * @return JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        if (! Gate::allows('delete category')) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( $category->services->count() > 0 || $category->doctors->count() > 0 || $category->doctors->count() > 0 || $category->lectures->count() > 0 || $category->medicalCase->count() > 0 ) {

            return response()->json([
                'code' => Response::HTTP_NOT_ACCEPTABLE,
                'message'=> __('messages.response.you_cant_delete_this')
            ], Response::HTTP_NOT_ACCEPTABLE); // Status code here

        }

        # check if repository not delete category return alert.
        if( !$this->categoriesRepository->delete($category) ) {
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
