<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Blog;
use App\Models\BlogPostCategory;


class IndexController extends Controller
{
    public function index()
    {
        $sliders = Slider::query()
                ->where('status', '=', 1)
                ->get();
        
        $introBlogPosts = Blog::query()
                ->where('important', '=', '1')
                ->where('status', '=', '1')
                ->orderBy('created_at', 'DESC')
                ->take(3)
                ->get();
        
        $latestBlogs1 = Blog::query()
                ->where('status', '=', '1')
                ->orderBy('created_at', 'DESC')
                ->take(3)
                ->get();
        
        $latestBlogs2 = Blog::query()
                ->where('status', '=', '1')
                ->orderBy('created_at', 'DESC')
                ->skip(3)
                ->take(3)
                ->get();
        
        $latestBlogs3 = Blog::query()
                ->where('status', '=', '1')
                ->orderBy('created_at', 'DESC')
                ->skip(6)
                ->take(3)
                ->get();
        
        $latestBlogs4 = Blog::query()
                ->where('status', '=', '1')
                ->orderBy('created_at', 'DESC')
                ->skip(9)
                ->take(3)
                ->get();
        
        //dd($latestBlogs);
        $footerCategories = BlogPostCategory::query()
                ->orderBy('priority', 'DESC')
                ->take(4)
                ->get();
        
        $newestFooterBlogPosts = Blog::where('status', '=', '1')
                ->orderBy('created_at', 'desc')
                ->take(3)->get();   
        
        return view ('front.index.index', [
            'sliders' => $sliders,
            'introBlogPosts' => $introBlogPosts,
            'latestBlogs1' => $latestBlogs1,
            'latestBlogs2' => $latestBlogs2,
            'latestBlogs3' => $latestBlogs3,
            'latestBlogs4' => $latestBlogs4,
            'footerCategories' => $footerCategories,
            'footerBlogs' => $newestFooterBlogPosts
            
        ]);
    }
    
    
    
    
}
