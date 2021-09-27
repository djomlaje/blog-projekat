@extends('front._layout.layout')

@section('seo_title', __('Tags Page'))
@section('seo_description', __('Blogs in your best tags ') . $tag->name)


@section('content')

<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="posts-listing col-lg-8"> 
            <div class="container">
                <h2 class="mb-3"><?php echo htmlspecialchars("Tag " . '"' . $tag->name . '"'); ?></h2>
                <div class="row">
                    @foreach($listingBlogs as $listingBlog)
                    <!-- post -->
                    <div class="post col-xl-6">
                        <div class="post-thumbnail"><a href="{{$listingBlog->getFrontUrl()}}"><img src="{{$listingBlog->getPhoto1Url()}}" alt="..." class="img-fluid"></a></div>
                        <div class="post-details">
                            <div class="post-meta d-flex justify-content-between">
                                <div class="date meta-last">{{date('d M | Y', strtotime($listingBlog->created_at))}}</div>
                                <div class="category">
                                    @if(isset($listingBlog->blogPostCategory->id))
                                        <a 
                                        href="{{$listingBlog->getCategoryUrl()}}"
                                        >{{$listingBlog->blogPostCategory->name}}</a>
                                        @else 
                                        <a href="#" onclick="return false;">Uncategorized</a>
                                        @endif
                                </div>
                            </div><a href="{{$listingBlog->getFrontUrl()}}">
                                <h3 class="h4">{{$listingBlog->name}}</h3></a>
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                            <footer class="post-footer d-flex align-items-center"><a href="{{$listingBlog->getAuthorUrl()}}" class="author d-flex align-items-center flex-wrap">
                                    <div class="avatar"><img src="{{$listingBlog->users->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                                    <div class="title"><span>{{$listingBlog->users->name}}</span></div></a>
                                <div class="date"><i class="icon-clock"></i> {{Carbon\Carbon::parse($listingBlog->created_at)->diffForHumans()}}</div>
                                <div class="comments meta-last"><i class="icon-comment"></i>{{$listingBlog->comments->count()}}</div>
                            </footer>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Pagination -->
                <nav aria-label="Page navigation example">
                    {{$listingBlogs->render("pagination::bootstrap-4")}}
                </nav>
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