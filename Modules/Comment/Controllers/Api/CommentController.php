<?php

namespace Modules\Comment\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\Comment\Models\Comment;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $users = Comment::query()
            ->select('comments.*')
            ->when($request->get('q'), function (Builder $query) {
                $word = request()->get('q');

                return $query->whereRaw("(comments.body like '%{$word}%') or comments.id = '%{$word}%'");
            })
            ->orderBy('comments.'.request()->get('sort', 'created_at'), request()->get('direction', 'DESC'))
            ->orderBy('comments.id', request()->get('direction', 'DESC'))
            ->paginate(10);

        return response()->json($users);
    }

    /**
     * Update status.
     *
     * @param Comment $comment
     *
     * @return JsonResponse
     */
    public function changeStatus(Comment $comment): JsonResponse
    {
        if( !$comment->update(['status' => ($comment->status == 2 ? 1 : 2)]) ) {
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'message'=> __('messages.response.failed')
            ], Response::HTTP_BAD_REQUEST); // Status code here
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $comment,
            'message'=> __('messages.response.updated')
        ], Response::HTTP_OK); // Status code here
    }

    /**
     * Remove the specified comment from storage.
     *
     * @param Comment $comment
     *
     * @return JsonResponse
     */
    public function destroy(Comment $comment): JsonResponse
    {
        # check if repository not delete comment return alert.
        if( !$comment->delete() ){
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
