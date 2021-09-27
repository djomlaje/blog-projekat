<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use App\Models\BlogPostCategory;
use App\Models\Tag;
use App\Models\BlogPostTag;
use App\Models\Comment;
use Carbon\Carbon;

class BlogsController extends Controller {

    public function index(Request $request) {

        //Vadjenje kategorija po prioritetu u "aside" tagu
        $categories = BlogPostCategory::query()
                ->orderBy('priority', 'ASC')
                ->withCount(['blogPosts'])
                ->get();


        $blogsName = Blog::query()
                        ->get()->pluck('name');
        //dobijanje tagova koji su se najavise koristili i njihovo sortiranje
        $mostUsedTags = Tag::whereHas('blogPosts', function($query) use ($blogsName) {
                    $query->whereIn('name', $blogsName);
                })
                ->withCount(['blogPosts'])
                ->orderBy('blog_posts_count', 'DESC')
                ->get();

        //izlistavanje postova i ucitavanje tagova i kategorija iz baze
        $blogPosts = Blog::query()
                ->with(['blogPostCategory', 'tags'])
                ->where('status', '=', '1')
                ->paginate(12);

        //ucitavanje autora postova
        $users = User::query()
                ->orderBy('name')
                ->get();

        //poslednja 3 posta
        $latestPosts = Blog::query()
                        ->where('status', '=', 1)
                        ->where('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString())
                        ->orderBy('views', 'DESC')
                        ->take(3)->get();

        //footer, kategorije
        $footerCategories = BlogPostCategory::query()
                ->orderBy('priority', 'DESC')
                ->take(4)
                ->get();



        return view('front.blogs.index', [
            'blogPosts' => $blogPosts,
            'users' => $users,
            'categories' => $categories,
            'mostUsedTags' => $mostUsedTags,
            'latestPosts' => $latestPosts,
            'footerCategories' => $footerCategories,
        ]);
    }

    public function single(Request $request, Blog $blog, $seoSlug = null) {

        if ($seoSlug != \Str::slug($blog->name)) {
            return redirect()->away($blog->getFrontUrl());
        }
        
        if ($blog->status == 0) {
            abort(404, 'Page not found');
        }

        $categories = BlogPostCategory::query()
                ->orderBy('priority', 'ASC')
                ->withCount(['blogPosts'])
                ->get();

        $blogsName = Blog::query()
                        ->get()->pluck('name');

        $mostUsedTags = Tag::whereHas('blogPosts', function($query) use ($blogsName) {
                    $query->whereIn('name', $blogsName);
                })
                ->withCount(['blogPosts'])
                ->orderBy('blog_posts_count', 'DESC')
                ->get();

        $latestPosts = Blog::query()
                        ->where('status', '=', 1)
                        ->where('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString())
                        ->orderBy('views', 'DESC')
                        ->take(3)->get();

        $footerCategories = BlogPostCategory::query()
                ->orderBy('priority', 'DESC')
                ->take(4)
                ->get();

        $blog->incrementReadCount();

        $comments = Comment::query()
                ->where('status', '=', '1')
                ->where('blog_post_id', '=', $blog->id)
                ->orderBy('created_at')
                ->get();

        $commentsCount = $comments->count();




        return view('front.blogs.single', [
            'blog' => $blog,
            'categories' => $categories,
            'mostUsedTags' => $mostUsedTags,
            'latestPosts' => $latestPosts,
            'footerCategories' => $footerCategories,
            'comments' => $comments,
            'commentsCount' => $commentsCount,
        ]);
    }

    public function category(Request $request, BlogPostCategory $category, $seoSlug = null) {

        $blogs = Blog::query()
                ->where('blog_post_category_id', '=', $category->id)
                ->where('status', '=', '1')
                ->orderBy('created_at', 'DESC')
                ->paginate(4);


        //provjera da li postoje proizvodi u kategoriji, kad se pokusa uci na listu sa admin dijela ili rucno
        if ($blogs->count() < 1) {
            throw new \Exception('Nema blog postova u ovoj kategoriji');
        }

        $categories = BlogPostCategory::query()
                ->orderBy('priority', 'ASC')
                ->withCount(['blogPosts'])
                ->get();

        $blogsName = Blog::query()
                        ->get()->pluck('name');

        $mostUsedTags = Tag::whereHas('blogPosts', function($query) use ($blogsName) {
                    $query->whereIn('name', $blogsName);
                })
                ->withCount(['blogPosts'])
                ->orderBy('blog_posts_count', 'DESC')
                ->get();

        $latestPosts = Blog::query()
                        ->where('status', '=', 1)
                        ->where('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString())
                        ->orderBy('views', 'DESC')
                        ->take(3)->get();

        $footerCategories = BlogPostCategory::query()
                ->orderBy('priority', 'DESC')
                ->take(4)
                ->get();

        return view('front.blogs.categories', [
            'category' => $category,
            'blogs' => $blogs,
            'categories' => $categories,
            'mostUsedTags' => $mostUsedTags,
            'latestPosts' => $latestPosts,
            'footerCategories' => $footerCategories,
        ]);
    }

    public function author(Request $request, User $author, $seoSlug = null) {
        $blogs = Blog::query()
                ->where('blog_post_user_id', '=', $author->id)
                ->where('status', '=', '1')
                ->orderBy('created_at', 'DESC')
                ->paginate(4);

        $latestPosts = Blog::query()
                        ->where('status', '=', 1)
                        ->where('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString())
                        ->orderBy('views', 'DESC')
                        ->take(3)->get();

        $categories = BlogPostCategory::query()
                ->orderBy('priority', 'ASC')
                ->withCount(['blogPosts'])
                ->get();

        $blogsName = Blog::query()
                        ->get()->pluck('name');

        $mostUsedTags = Tag::whereHas('blogPosts', function($query) use ($blogsName) {
                    $query->whereIn('name', $blogsName);
                })
                ->withCount(['blogPosts'])
                ->orderBy('blog_posts_count', 'DESC')
                ->get();


        $footerCategories = BlogPostCategory::query()
                ->orderBy('priority', 'DESC')
                ->take(4)
                ->get();

        return view('front.blogs.author', [
            'user' => $author,
            'blogs' => $blogs,
            'latestPosts' => $latestPosts,
            'categories' => $categories,
            'mostUsedTags' => $mostUsedTags,
            'footerCategories' => $footerCategories,
        ]);
    }

    public function tag(Request $request, Tag $tag, Blog $blog, $seoSlug = null) {
        $blogs = BlogPostTag::query()
                ->where('tag_id', '=', $tag->id)
                ->pluck('blog_post_id')
                ->toArray();

        $listingBlogs = Blog::query()
                ->whereIn('id', $blogs)
                ->where('status', '=', '1')
                ->orderBy('created_at', 'DESC')
                ->paginate(4);

        //provjera da li postoje proizvodi u kategoriji, kad se pokusa uci na listu sa admin dijela ili rucno
        if ($listingBlogs->count() < 1) {
            throw new \Exception('Nema blog postova u sa ovim tagom');
        }

        $categories = BlogPostCategory::query()
                ->orderBy('priority', 'ASC')
                ->withCount(['blogPosts'])
                ->get();

        //Svi nazivi blog postova
        $blogsName = Blog::query()
                        ->get()->pluck('name');

        //dobijanje najcesce koristenih tagova
        $mostUsedTags = Tag::whereHas('blogPosts', function($query) use ($blogsName) {
                    $query->whereIn('name', $blogsName);
                })
                ->withCount(['blogPosts'])
                ->orderBy('blog_posts_count', 'DESC')
                ->get();

        $latestPosts = Blog::query()
                        ->where('status', '=', 1)
                        ->where('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString())
                        ->orderBy('views', 'DESC')
                        ->take(3)->get();

        $footerCategories = BlogPostCategory::query()
                ->orderBy('priority', 'DESC')
                ->take(4)
                ->get();

        return view('front.blogs.tag', [
            'tag' => $tag,
            'listingBlogs' => $listingBlogs,
            'blogs' => $blogs,
            'categories' => $categories,
            'mostUsedTags' => $mostUsedTags,
            'latestPosts' => $latestPosts,
            'footerCategories' => $footerCategories,
        ]);
    }

    public function search(Request $request, $seoSlug = null) {

        $searchTerms = $request->validate([
            'searchTerms' => ['nullable', 'string', 'max:255']
        ]);
        
        $search_terms = explode(' ', $request->get('searchTerms'));
        $title = implode(" ", $search_terms);
        $query = Blog::query();
        foreach ($search_terms as $term) {
            $query->orWhere(function ($query) use ($term) {
                $query->orWhere('name', 'LIKE', '%' . $term . '%');
                $query->orWhere('description', 'LIKE', '%' . $term . '%');
        })
        ->where('status', '=', 1);}
        
        $blogs = $query->paginate(4);

        $latestPosts = Blog::query()
                        ->where('status', '=', 1)
                        ->where('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString())
                        ->orderBy('views', 'DESC')
                        ->take(3)->get();

        $categories = BlogPostCategory::query()
                ->orderBy('priority', 'ASC')
                ->withCount(['blogPosts'])
                ->get();

        $blogsName = Blog::query()
                        ->get()->pluck('name');

        $mostUsedTags = Tag::whereHas('blogPosts', function($query) use ($blogsName) {
                    $query->whereIn('name', $blogsName);
                })
                ->withCount(['blogPosts'])
                ->orderBy('blog_posts_count', 'DESC')
                ->get();

        $footerCategories = BlogPostCategory::query()
                ->orderBy('priority', 'DESC')
                ->take(4)
                ->get();

        return view('front.blogs.search', [
            'title' => $title,
            'blogs' => $blogs,
            'latestPosts' => $latestPosts,
            'categories' => $categories,
            'mostUsedTags' => $mostUsedTags,
            'footerCategories' => $footerCategories,
        ]);
    }

}
