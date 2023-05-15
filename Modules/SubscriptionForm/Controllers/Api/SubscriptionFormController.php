<?php

namespace Modules\SubscriptionForm\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Modules\ContactUs\Models\ContactUs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Modules\SubscriptionForm\Models\SubscriptionForm;
use Modules\SubscriptionForm\Repositories\SubscriptionFormRepository;

class SubscriptionFormController extends Controller
{
    protected $subscriptionFormRepository;

    /**
     * SubscriptionFormRepository
     *
     * @param SubscriptionFormRepository $subscriptionFormRepository
     */
    public function __construct(SubscriptionFormRepository $subscriptionFormRepository)
    {
        $this->subscriptionFormRepository = $subscriptionFormRepository;
    }

    public function index(Request $request)
    {
        return $this->subscriptionFormRepository->get($request->all());

        /*$contactUs = SubscriptionForm::query()
            ->select('subscription_forms.*')
            ->when($request->get('q'), function (Builder $query) {
                $word = request()->get('q');

                return $query->whereRaw("(subscription_forms.name like '%{$word}%' OR subscription_forms.phone like '%{$word}%' )");
            })
            ->orderBy(request()->get('sort', 'subscription_forms.created_at'), request()->get('direction', 'DESC'))
            ->orderBy('subscription_forms.id', request()->get('direction', 'DESC'))
            ->paginate(10);

        return response()->json($contactUs);*/
    }

    /**
     * Remove the specified category from storage.
     *
     * @param SubscriptionForm $subscription_form
     *
     * @return JsonResponse
     */
    public function destroy(SubscriptionForm $subscription_form): JsonResponse
    {
        if (! Gate::allows('delete subscription-form')){
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message'=> __('messages.response.forbidden')
            ], Response::HTTP_FORBIDDEN); // Status code here
        }

        # check if repository not delete category return alert.
        if( !$this->subscriptionFormRepository->delete($subscription_form) ){
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
