@extends('front._layout.layout')

@section('seo_title', $blog->name)
@section('seo_description', $blog->description)
@section('seo_image', $blog->getPhoto1Url())
@section('seo_og_type', 'blog_post')




@section('content')

<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="post blog-post col-lg-8"> 
            <div class="container">
                <div class="post-single">
                    <div class="post-thumbnail"><img src="{{url('themes/front/img/blog-post-3.jpeg')}}" alt="..." class="img-fluid"></div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="category">
                                @if(isset($blog->blogPostCategory->id))
                                <a 
                                    href="{{$blog->getCategoryUrl()}}"

                                    >{{$blog->blogPostCategory->name}}</a>
                                @else 
                                <a href="#" onclick="return false;">Uncategorized</a>
                                @endif</div>
                        </div>
                        <h1>{{$blog->name}}<a href="#"><i class="fa fa-bookmark-o"></i></a></h1>
                        <div class="post-footer d-flex align-items-center flex-column flex-sm-row"><a href="{{$blog->getAuthorUrl()}}" class="author d-flex align-items-center flex-wrap">
                                <div class="avatar"><img src="{{$blog->users->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                                <div class="title"><span>{{$blog->users->name}}</span></div></a>
                            <div class="d-flex align-items-center flex-wrap">       
                                <div class="date"><i class="icon-clock"></i> {{Carbon\Carbon::parse($blog->created_at)->diffForHumans()}}</div>
                                <div class="views"><i class="icon-eye"></i> {{$blog->views}}</div>
                                <div class="comments meta-last"><a href="#post-comments"><i class="icon-comment"></i>{{$blog->comments->count()}}</a></div>
                            </div>
                        </div>
                        <div class="post-body">
                            <p class="lead">{{$blog->description}}</p>
                            {!! $blog->details !!}
                        </div>
                        <div class="post-tags">
                            @foreach($blog->tags as $tag)
                            <a href="{{$tag->getFrontUrl()}}" class="tag">#{{$tag->name}}</a>
                            @endforeach
                            <div class="posts-nav d-flex justify-content-between align-items-stretch flex-column flex-md-row"><a href="{{$blog->getPreviousPost()}}" class="prev-post text-left d-flex align-items-center">
                                    <div class="icon prev"><i class="fa fa-angle-left"></i></div>
                                    <div class="text"><strong class="text-primary">Previous Post </strong>
                                        <h6>{{$blog->getPreviousPostName()}}</h6>
                                    </div></a><a href="{{$blog->getNextPost()}}" class="next-post text-right d-flex align-items-center justify-content-end">
                                    <div class="text"><strong class="text-primary">Next Post </strong>
                                        <h6>{{$blog->getNextPostName()}}</h6>
                                    </div>
                                    <div class="icon next"><i class="fa fa-angle-right">   </i></div></a></div>
                            @include('front.blogs.partials.comments.comments')

                        </div>
                    </div>
                </div>
        </main>
        <aside class="col-lg-4">
            <!-- Widget [Search Bar Widget]-->
            <div class="widget search">
                <header>
                    <h3 class="h6">@lang('Search the blog')</h3>
                </header>
                <form action="{{route('front.blogs.search')}}" method="get" class="search-form">
                    <div class="form-group">
                        <input type="search" placeholder="What are you looking for?" name="searchTerms">
                        <button type="submit" class="submit"><i class="icon-search"></i></button>
                    </div>
                </form>
            </div>
            <!-- Widget [Latest Posts Widget]        -->
            <div class="widget latest-posts">
                <header>
                    <h3 class="h6">Latest Posts</h3>
                </header>
                <div class="blog-posts">
                    @foreach($latestPosts as $latestPost)
                    <a href="{{$latestPost->getFrontUrl()}}">
                        <div class="item d-flex align-items-center">
                            <div class="image"><img src="{{url('themes/front/img/small-thumbnail-1.jpg')}}" alt="..." class="img-fluid"></div>
                            <div class="title"><strong>{{$latestPost->name}}</strong>
                                <div class="d-flex align-items-center">
                                    <div class="views"><i class="icon-eye"></i> {{$latestPost->views}}</div>
                                    <div class="comments"><i class="icon-comment"></i>{{$latestPost->comments->count()}}</div>
                                </div>
                            </div>
                        </div></a>
                    @endforeach
                </div>
            </div>
            <!-- Widget [Categories Widget]-->
            <div class="widget categories">
                <header>
                    <h3 class="h6">Categories</h3>
                </header>
                @foreach($categories as $category)
                <div class="item d-flex justify-content-between"><a href="{{$category->getFrontUrl()}}">{{$category->name}}</a><span>{{$category->blog_posts_count}}</span></div>
                @endforeach
            </div>
            <!-- Widget [Tags Cloud Widget]-->
            <div class="widget tags">       
                <header>
                    <h3 class="h6">Tags</h3>
                </header>
                <ul class="list-inline">
                    @foreach($mostUsedTags as $mostUsedTag)
                    <li class="list-inline-item"><a href="{{$mostUsedTag->getFrontUrl()}}" class="tag">#{{$mostUsedTag->name}}</a></li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
</div>

@endsection

