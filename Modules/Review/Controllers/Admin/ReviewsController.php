<?php

namespace Modules\Review\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\Review\Enums\ReviewEnum;
use Modules\Review\Models\Review;
use Modules\Review\Repositories\ReviewsRepository;

class ReviewsController extends Controller
{
    private $reviewsRepository;
    private $viewsPath = 'Review.Resources.views.';

    /**
     * ReviewsController constructor.
     *
     * @param ReviewsRepository $reviewsRepository
     */
    public function __construct(ReviewsRepository $reviewsRepository)
    {
        $this->reviewsRepository = $reviewsRepository;
    }

    /**
     * Display a listing of the reviews.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view("$this->viewsPath.index");
    }

    public function edit(Review $review)
    {
        $status = ReviewEnum::stauts;

        return view($this->viewsPath.'edit', compact('review', 'status'));
    }

    public function exportCsv(Request $request)
    {
        $fileName = 'reviews.csv';

        # Repository to list reviews.
        $reviews = $this->reviewsRepository->list($request->all());

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('name', 'phone', 'message', 'status', 'branch', 'doctor', 'created_at');

        $callback = function () use ($reviews, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns);

            foreach ($reviews as $review) {
                $row['name'] = $review->name;
                $row['phone'] = $review->phone;
                $row['message'] = $review->message;
                $row['status'] = $review->statusData['label'] ?? 'N/A';
                $row['branch'] = $review->branch->name ?? 'N/A';
                $row['doctor'] = $review->doctor->name ?? 'N/A';
                $row['created_at'] = $review->created_at;

                fputcsv($file, array($row['name'], $row['phone'], $row['message'], $row['status'], $row['branch'], $row['doctor'], $row['created_at']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

