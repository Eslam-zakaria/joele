<?php

namespace App\Http\Controllers;

use App\Http\Requests\Search\GlobalSearchRequest;
use Illuminate\Http\Request;
use Modules\Blog\Repositories\BlogsRepository;
use Modules\Cases\Repositories\CasesRepository;
use Modules\Category\Repositories\CategoriesRepository;
use Modules\Doctor\Repositories\DoctorsRepository;
use Modules\InsuranceCompany\Models\InsuranceCompany;
use Modules\InsuranceCompany\Repositories\InsuranceCompanyRepository;
use Modules\Lecture\Repositories\LecturesRepository;
use Modules\Lecture\Seeds\LectureSeeder;
use Modules\Review\Repositories\ReviewsRepository;
use Modules\Slider\Repositories\SlidersRepository;
use Modules\Testimonial\Repositories\TestimonialsRepository;
use Modules\Blog\Models\Blog;
use Modules\Blog\Models\BlogSection;
use DB;

class HomeController extends Controller
{
    /**
     * Get home page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $getBlogTranslation = DB::table('blog_section_translations')->where('locale','ar')->get();
        // dd($getBlogTranslation);
        foreach($getBlogTranslation as $blogTranslation){
            BlogSection::where('id',$blogTranslation->blog_section_id)->update(['title' => $blogTranslation->title ,
            'content' => $blogTranslation->content,
            'section_color' => $blogTranslation->section_color,
        ]);
        }
        // dd($getBlogTranslation);
        $lang = app()->getLocale() == 'en'  ?  'en' : 'ar';
        # Repository to list sliders.
        $sliders = app(SlidersRepository::class)->list();

        # Repository to list categories.
        $categories = app(CategoriesRepository::class)->all();

        # Repository to list doctors.
        $doctors = app(DoctorsRepository::class)->lastN();

        # Repository to list cases.
        $cases = app(CasesRepository::class)->lastN();

        # Repository to list reviews.
        $reviews = app(ReviewsRepository::class)->lastN();

        # Repository to list blogs.
        $blogs = app(BlogsRepository::class)->lastN(6,$lang);

        # Repository to list lectures.
        $lectures = app(LecturesRepository::class)->lastN();

        # Repository to list insurance companies.
        $insuranceCompanies = app(InsuranceCompanyRepository::class)->list();

        return view('frontend.home.index', compact('sliders', 'categories', 'doctors', 'cases', 'reviews', 'blogs', 'lectures', 'insuranceCompanies'));
    }

    /**
     * Get to the specification page to display search results.
     *
     * @param GlobalSearchRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(GlobalSearchRequest $request)
    {
        return view('frontend.home.search');
    }

    /**
     * Get home page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function robots()
    {
        return response(\View::make('frontend.home.robots'))
            ->header('Content-Type', 'text/plain');
    }
}
