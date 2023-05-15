<?php

namespace Modules\Blog\Controllers\Web;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\Models\Blog;
use Modules\Blog\Models\BlogSection;
use Modules\Blog\Repositories\BlogsRepository;
use Modules\Branch\Repositories\BranchesRepository;
use Modules\Category\Repositories\CategoriesRepository;
use Modules\Comment\Constants\CommentStatus;
use Modules\Comment\Models\Comment;

class BlogsController extends Controller
{
    private $blogsRepository;
    private $categoriesRepository;
    private $viewsPath = 'Blog.Resources.views.';

    /**
     * BlogCategoryController constructor.
     *
     * @param BlogsRepository $blogsRepository
     * @param CategoriesRepository $categoriesRepository
     * @param BranchesRepository $branchesRepository
     */
    public function __construct(BlogsRepository $blogsRepository, CategoriesRepository $categoriesRepository)
    {
        $this->blogsRepository = $blogsRepository;
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * Display a listing of the blogs.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // if(app()->getLocale() == 'en')
        //     return redirect('/', 301);
        $lang = app()->getLocale() == 'en'  ?  'en' : 'ar';
        # Repository to list blogs.
        $blogs = $this->blogsRepository->list($request->all(),$lang);

        # Repository to list categories.
        $categories = $this->categoriesRepository->list('blogs');

        return view("$this->viewsPath.web.index", compact('blogs', 'categories'));
    }

    /**
     * Display blog details.
     *
     * @param $slug
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function details($slug)
    {
        // if(app()->getLocale() == 'en')
        //     return redirect('/', 301);
        $lang = app()->getLocale() == 'en'  ?  'en' : 'ar';
        # Repository to get specification blog by slug.
        $blog = $this->blogsRepository->bySlug($slug);

        if( !$blog )
            return abort(404);

       # Repository to get specification blog by lang.
        $blogLang = $this->blogsRepository->byLang($blog->id,$lang);

        # check if blog is exists.
        if( !$blog )
            return redirect('/');

        # check if blog has new slug.
        if( $blog->new_slug && $blog->slug == $slug )
            return redirect($blog->new_slug, 301);

        # Get related blogs.
        $relatedBlogs = $this->blogsRepository->related($blog, 5 , $lang);

        $comments = Comment::where('status', CommentStatus::APPROVED)->where('blog_id', $blog->id)->get();

        $sections = BlogSection::where('blog_id', $blog->id)->orderBy('sorting', 'asc')->get();

        $getQuestions  = $blog->faqs()->get();

        return view($this->viewsPath.'web.details', compact('blog', 'comments', 'relatedBlogs', 'relatedBlogs', 'sections','getQuestions','blogLang'));
    }

    public function comment(Request $request, Blog $blog)
    {
        $criteria = [
            'name' => 'required',
            'phone' => 'required',
            'comment' => 'required',
        ];

        $request->validate($criteria);
        $comment = new Comment();
        $comment->blog_id = $blog->id;
        $comment->fill($request->all());

        $comment->save();

        return redirect()->back()->with('success', __('messages.response.commentsuccess'));
    }
}
