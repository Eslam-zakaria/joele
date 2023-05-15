<?php

namespace Modules\SubscriptionForm\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\SubscriptionForm\Repositories\SubscriptionFormRepository;

class SubscriptionFormController extends Controller
{
    protected $subscriptionFormRepository;
    private $viewsPath = 'SubscriptionForm.Resources.views.';

    /**
     * SubscriptionFormRepository
     *
     * @param SubscriptionFormRepository $subscriptionFormRepository
     */
    public function __construct(SubscriptionFormRepository $subscriptionFormRepository)
    {
        $this->subscriptionFormRepository = $subscriptionFormRepository;
    }

    /**
     * Display a listing of the contact us.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list subscription-form'))
            abort(403);

        return view($this->viewsPath.'index');
    }

    public function exportCsv(Request $request)
    {
        $fileName = 'subscription_form.csv';

        # Repository to list reviews.
        $subscriptionForm = $this->subscriptionFormRepository->list($request->all());

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('phone', 'created_at');

        $callback = function () use ($subscriptionForm, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns);

            foreach ($subscriptionForm as $data) {
                $row['phone'] = $data->phone;
                $row['created_at'] = $data->created_at;

                fputcsv($file, array($row['phone'], $row['created_at']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
