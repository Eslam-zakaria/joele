<?php

namespace Modules\Service\Controllers\Web;

use App\Http\Controllers\Controller;
use Modules\Service\Repositories\ServicesRepository;
use Modules\Category\Repositories\CategoriesRepository;

class ServiceController extends Controller
{
    private $servicesRepository;
    private $categoriesRepository;
    private $viewsPath = 'Service.Resources.views.';

    /**
     * ServiceController constructor.
     *
     * @param ServicesRepository $servicesRepository
     * @param CategoriesRepository $categoriesRepository
     */
    public function __construct(ServicesRepository $servicesRepository, CategoriesRepository $categoriesRepository)
    {
        $this->servicesRepository = $servicesRepository;
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * List categories.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        # Repository to list categories.
        $categories = $this->categoriesRepository->list('services', ['translation']);

        return view($this->viewsPath . 'web.index', compact('categories'));
    }

    /**
     * List services by category.
     *
     * @param string $slug
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getServices(string $slug)
    {
        # Repository to get specific categories.
        $category = $this->categoriesRepository->categoriesPage($slug);

        # Repository to list services.
        $services = $this->servicesRepository->servicesPage($category->category_id);

        # Repository to list categories.
        $categories = $this->categoriesRepository->list('services',['translation']);

        return view($this->viewsPath.'web.list', compact('services','category','categories'));
    }

    /**
     * Get specification model by slug.
     *
     * @param string $slug
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function details(string $slug)
    {
        # Repository to get specific categories.
        $service = $this->servicesRepository->detailsPage($slug);

        if( !$service )
            return abort(404);

        $servicesRelated = $this->servicesRepository->servicesRelated($service->id,$service->category_id);

        //check if no data response redirect on home with 301
        if( !$service )
            return redirect(301)->route('web.home.index');

        //check $slug == new_slug or slug redirect on new_slug with 301
        if( !empty($service->new_slug) && $service->slug == $slug )
            return redirect(301)->route('web.services.details', ['slug' => $service->new_slug ]);

        $getQuestions  = $service->faqPage()->get();

        return view($this->viewsPath.'web.details', compact('service','servicesRelated','getQuestions'));
    }
}
