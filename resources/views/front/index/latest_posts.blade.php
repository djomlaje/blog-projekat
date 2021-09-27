<div class="container">
    <header> 
        <h2>@lang('Latest from the blog')</h2>
        <p class="text-big">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
    </header>
    <div class="owl-carousel" id="latest-posts-slider">
        
        <div class="row">
            @foreach($latestBlogs1 as $latestBlog1)
            <div class="post col-md-4">
                <div class="post-thumbnail"><a href="{{$latestBlog1->getFrontUrl()}}"><img src="{{$latestBlog1->getPhoto1Url()}}" alt="..." class="img-fluid"></a></div>
                <div class="post-details">
                    <div class="post-meta d-flex justify-content-between">
                        <div class="date">{{date('d M | Y', strtotime($latestBlog1->created_at))}}</div>
                        <div class="category"><a href="blog-category.html">{{optional($latestBlog1->blogPostCategory)->name}}</a></div>
                    </div><a href="{{$latestBlog1->getFrontUrl()}}">
                        <h3 class="h4">{{$latestBlog1->name}}</h3></a>
                    <p class="text-muted">{{$latestBlog1->description}}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            @foreach($latestBlogs2 as $latestBlog2)
            <div class="post col-md-4">
                <div class="post-thumbnail"><a href="{{$latestBlog2->getFrontUrl()}}"><img src="{{$latestBlog2->getPhoto1Url()}}" alt="..." class="img-fluid"></a></div>
                <div class="post-details">
                    <div class="post-meta d-flex justify-content-between">
                        <div class="date">{{date('d M | Y', strtotime($latestBlog2->created_at))}}</div>
                        <div class="category"><a href="blog-category.html">{{optional($latestBlog2->blogPostCategory)->name}}</a></div>
                    </div><a href="{{$latestBlog2->getFrontUrl()}}">
                        <h3 class="h4">{{$latestBlog2->name}}</h3></a>
                    <p class="text-muted">{{$latestBlog2->description}}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            @foreach($latestBlogs3 as $latestBlog3)
            <div class="post col-md-4">
                <div class="post-thumbnail"><a href="{{$latestBlog3->getFrontUrl()}}"><img src="{{$latestBlog3->getPhoto1Url()}}" alt="..." class="img-fluid"></a></div>
                <div class="post-details">
                    <div class="post-meta d-flex justify-content-between">
                        <div class="date">{{date('d M | Y', strtotime($latestBlog3->created_at))}}</div>
                        <div class="category"><a href="blog-category.html">{{optional($latestBlog3->blogPostCategory)->name}}</a></div>
                    </div><a href="{{$latestBlog2->getFrontUrl()}}">
                        <h3 class="h4">{{$latestBlog3->name}}</h3></a>
                    <p class="text-muted">{{$latestBlog3->description}}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            @foreach($latestBlogs4 as $latestBlog4)
            <div class="post col-md-4">
                <div class="post-thumbnail"><a href="{{$latestBlog4->getFrontUrl()}}"><img src="{{$latestBlog4->getPhoto1Url()}}" alt="..." class="img-fluid"></a></div>
                <div class="post-details">
                    <div class="post-meta d-flex justify-content-between">
                        <div class="date">{{date('d M | Y', strtotime($latestBlog4->created_at))}}</div>
                        <div class="category"><a href="blog-category.html">{{optional($latestBlog4->blogPostCategory)->name}}</a></div>
                    </div><a href="{{$latestBlog4->getFrontUrl()}}">
                        <h3 class="h4">{{$latestBlog4->name}}</h3></a>
                    <p class="text-muted">{{$latestBlog4->description}}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>