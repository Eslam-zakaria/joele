<?php

namespace Modules\ContactUs\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\ContactUs\Models\ContactUs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Modules\ContactUs\Repositories\ContactUsRepository;

class ContactUsController extends Controller
{
    protected $contactUsRepository;

    /**
     * ContactUsRepository
     *
     * @param ContactUsRepository $contactUsRepository
     */
    public function __construct(ContactUsRepository $contactUsRepository)
    {
        $this->contactUsRepository = $contactUsRepository;
    }

    public function index(Request $request)
    {
        $contactUs = ContactUs::query()
            ->select('contact_us.*')
            ->when($request->get('q'), function (Builder $query) {
                $word = request()->get('q');

                return $query->whereRaw("(contact_us.name like '%{$word}%' OR contact_us.phone like '%{$word}%' )");
            })
            ->orderBy(request()->get('sort', 'contact_us.created_at'), request()->get('direction', 'DESC'))
            ->orderBy('contact_us.id', request()->get('direction', 'DESC'))
            ->paginate(10);

        return response()->json($contactUs);
    }

    /**
     * Remove the specified category from storage.
     *
     * @param ContactUs $contact_u
     *
     * @return JsonResponse
     */
    public function destroy(ContactUs $contact_u): JsonResponse
    {
        if (! Gate::allows('delete contact-us')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        # check if repository not delete category return alert.
        if( !$this->contactUsRepository->delete($contact_u) ){
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
