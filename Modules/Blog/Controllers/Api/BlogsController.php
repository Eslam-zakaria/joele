<?php

namespace Modules\Blog\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\Blog\Models\Blog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Modules\Blog\Repositories\BlogsRepository;

class BlogsController extends Controller
{
    private $blogsRepository;

    /**
     * BlogCategoryController constructor.
     *
     * @param BlogsRepository $blogsRepository
     */
    public function __construct(BlogsRepository $blogsRepository)
    {
        $this->blogsRepository = $blogsRepository;
    }

    /**
     * Get collection with pagination of blogs.
     *
     * @param Request $request
     * @uses \Modules\Blog\Repositories\BlogsRepository::get()
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\phpDocumentor\Reflection\Types\Collection
     */
    public function index(Request $request)
    {
        # Repository to get collection with pagination of blogs.
        return $this->blogsRepository->get($request->all());
    }

    /**
     * Update blog status.
     *
     * @param Blog $blog
     *
     * @return JsonResponse
     */
    public function changeStatus(Blog $blog): JsonResponse
    {
        if (! Gate::allows('edit blog')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        if( !$this->blogsRepository->update($blog, ['status' => ($blog->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $blog,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified blog from storage.
     *
     * @param Blog $blog
     *
     * @return JsonResponse
     */
    public function destroy(Blog $blog): JsonResponse
    {
        if (! Gate::allows('delete blog')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        # check if repository not delete lecture return alert.
        if( !$this->blogsRepository->delete($blog) ){
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
