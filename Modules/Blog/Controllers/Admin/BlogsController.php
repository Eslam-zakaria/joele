<?php

namespace Modules\Blog\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Modules\Blog\Models\Blog;
use Modules\Blog\Http\Requests\BlogUpdateRequest;
use Modules\Blog\Http\Requests\BlogStoreRequest;
use Modules\Blog\Repositories\BlogsRepository;
use Modules\Category\Repositories\CategoriesRepository;
use Modules\Doctor\Repositories\DoctorsRepository;
use Modules\Blog\Models\BlogFaq;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    private $blogsRepository;
    private $categoriesRepository;
    private $viewsPath = 'Blog.Resources.views.';

    /**
     * BlogsController constructor.
     *
     * @param BlogsRepository $blogsRepository
     * @param CategoriesRepository $categoriesRepository
     */
    public function __construct(BlogsRepository $blogsRepository, CategoriesRepository $categoriesRepository)
    {
        $this->blogsRepository = $blogsRepository;
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * Display a listing of the blogs.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list blogs'))
            abort(403);

        return view("$this->viewsPath.index");
    }

    /**
     * Show the form for creating a new blog.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        if (! Gate::allows('create blog'))
            abort(403);

        # Repository list active doctors by assign display model.
        $doctors = app(DoctorsRepository::class)->listData();

        # Repository list active categories by assign display model.
        $categories = $this->categoriesRepository->list('blogs');

        return view("$this->viewsPath.create", compact('categories', 'doctors'));
    }

    /**
     * Store a newly created blog in storage.
     *
     * @param BlogStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(BlogStoreRequest $request): RedirectResponse
    {
        # check if repository not create blog return alert.
        if( !$this->blogsRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('admin.blogs.index')->with('success', __('messages.response.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified blog.
     *
     * @param Blog $blog
     *
     * @return Application|Factory|View
     */
    public function edit(Blog $blog)
    {
        if (! Gate::allows('edit blog'))
            abort(403);

        # Repository list active doctors by assign display model.
        $doctors = app(DoctorsRepository::class)->listData();

        # Repository list active categories by assign display model.
        $categories = $this->categoriesRepository->list('blogs');

        $getQuestions  = $blog->faqs()->get();

        if($blog->parent_id){
            $Allblogs = Blog::where('locale','!=', $blog->locale)->where('category_id',$blog->category_id)->where('status', 2)->get();

        } else {
            $Allblogs = Blog::where('locale','!=', $blog->locale)->where('category_id',$blog->category_id)->whereNull('parent_id')->where('status', 2)->get();
        }


        return view("$this->viewsPath.edit", compact('blog', 'categories', 'doctors','getQuestions','Allblogs'));
    }

    /**
     * Update the specified blog in storage.
     *
     * @param BlogUpdateRequest $request
     * @param Blog $blog
     *
     * @return RedirectResponse
     */
    public function update(BlogUpdateRequest $request, Blog $blog): RedirectResponse
    {
        # check if repository not update blog return alert.
        if( !$this->blogsRepository->update( $blog, $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.response.field_process'));

        if( isset($request['experienceEdit']) ){
            foreach ($request['experienceEdit'] as $experienceData) {
                $details = BlogFaq::findOrFail($experienceData['id']);
                $details->update($experienceData);
            }
        }
        return redirect()->route('admin.blogs.index')->with('success', __('messages.response.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return void
     */
    public function destroy(int $id)
    {
        //
    }

    /**
     * Get view to copy blog.
     *
     * @param Blog $blog
     *
     * @return Application|Factory|\Illuminate\View\View
     */
    public function copy(Blog $blog)
    {
        # Repository list active doctors by assign display model.
        $doctors = app(DoctorsRepository::class)->list();

        # Repository list active categories by assign display model.
        $categories = $this->categoriesRepository->list('blogs');

        return view("$this->viewsPath.copy", compact('blog', 'doctors', 'categories'));
    }


    public function BlogsAjax(Request $request)
    {
        $blogs = Blog::doesnthave('childs')->where('locale','!=', $request->locale_input)->where('category_id',$request->category_id)->whereNull('parent_id')->where('status', 2)->get();
        if (!count($blogs) > 0) {
            return response()->json(['status' => 401, 'data' => []], 200);
        }
        return response()->json(['status' => 200, 'data' => $blogs], 200);
    }

    public function Faqdelete(BlogFaq $question)
    {
        try {

            $question->delete();

        } catch (\Exception $e){

            return false;
        }

        return redirect()->back()->with('success', __('messages.response.deleted'));
    }


    public function reCopy(Blog $blog)
    {
        $addCopy = Blog::create([
            'category_id' => $blog->category_id,
            'doctor_id' => $blog->doctor_id,
            'locale' => $blog->locale,
            'title' => 'Draft: '.$blog->title,
            'slug' => $blog->slug.'_'.random_int(100000, 999999),
            'new_slug' => $blog->new_slug ? $blog->new_slug.'_'.random_int(100000, 999999) : Null,
            'description' => $blog->description,
            'parent_id' => $blog->parent_id ?? Null,
            'meta_title' => $blog->meta_title,
            'meta_description' => $blog->meta_description,
            'meta_keywords' => $blog->meta_keywords,
            'canonical' => $blog->canonical,
            'alt_image' => $blog->alt_image,
            'status' => 1,
        ]);

        if ($firstMedia = $blog->getFirstMedia('blog_image')) {
            $addCopy->addMediaFromUrl($firstMedia->getUrl(), 'blog_image');
        }


        if (isset($blog->sections)){

            foreach ($blog->sections()->get()->toArray() as $section){

                $addCopy->sections()->create($section);
            }

        }

        if( isset($blog->faqs) ){
            foreach ($blog->faqs()->get()->toArray() as $questionData) {

                $addCopy->faqs()->create($questionData);
            }
        }

        return redirect()->route('admin.blogs.index')->with('success', __('messages.response.copied'));
    }
}

