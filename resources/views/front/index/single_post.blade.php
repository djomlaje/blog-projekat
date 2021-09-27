<!-- Post-->
<div class="row d-flex align-items-stretch">
    <div class="text col-lg-7">
        <div class="text-inner d-flex align-items-center">
            <div class="content">
                <header class="post-header">
                    <div class="category"><a href="blog-category.html">{{optional($introBlogPosts[0]->blogPostCategory)->name}}</a></div><a href="{{$introBlogPosts[0]->getFrontUrl()}}">
                        <h2 class="h4">{{$introBlogPosts[0]->name}}</h2></a>
                </header>
                <p>{{$introBlogPosts[0]->description}}</p>
                <footer class="post-footer d-flex align-items-center"><a href="{{$introBlogPosts[0]->getAuthorUrl()}}" class="author d-flex align-items-center flex-wrap">
                        <div class="avatar"><img src="{{$introBlogPosts[0]->users->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                        <div class="title"><span>{{$introBlogPosts[0]->users->name}}</span></div></a>
                    <div class="date"><i class="icon-clock"></i> {{Carbon\Carbon::parse($introBlogPosts[0]->created_at)->diffForHumans()}}</div>
                    <div class="comments"><i class="icon-comment"></i>{{$introBlogPosts[0]->comments->count()}}</div>
                </footer>
            </div>
        </div>
    </div>
    <div class="image col-lg-5"><img src="{{$introBlogPosts[0]->getPhoto1Url()}}" alt="..."></div>
</div>
<!-- Post        -->
<div class="row d-flex align-items-stretch">
    <div class="image col-lg-5"><img src="{{$introBlogPosts[1]->getPhoto1Url()}}" alt="..."></div>
    <div class="text col-lg-7">
        <div class="text-inner d-flex align-items-center">
            <div class="content">
                <header class="post-header">
                    <div class="category"><a href="blog-category.html">{{optional($introBlogPosts[1]->blogPostCategory)->name}}</a></div><a href="{{$introBlogPosts[1]->getFrontUrl()}}">
                        <h2 class="h4">{{$introBlogPosts[1]->name}}</h2></a>
                </header>
                <p>{{$introBlogPosts[1]->description}}</p>
                <footer class="post-footer d-flex align-items-center"><a href="{{$introBlogPosts[1]->getAuthorUrl()}}" class="author d-flex align-items-center flex-wrap">
                        <div class="avatar"><img src="{{$introBlogPosts[1]->users->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                        <div class="title"><span>{{$introBlogPosts[1]->users->name}}</span></div></a>
                    <div class="date"><i class="icon-clock"></i> {{Carbon\Carbon::parse($introBlogPosts[1]->created_at)->diffForHumans()}}</div>
                    <div class="comments"><i class="icon-comment"></i>{{$introBlogPosts[1]->comments->count()}}</div>
                </footer>
            </div>
        </div>
    </div>
</div>
<!-- Post                            -->
<div class="row d-flex align-items-stretch">
    <div class="text col-lg-7">
        <div class="text-inner d-flex align-items-center">
            <div class="content">
                <header class="post-header">
                    <div class="category"><a href="blog-category.html">{{optional($introBlogPosts[2]->blogPostCategory)->name}}</a></div>
                    <a href="{{$introBlogPosts[2]->getFrontUrl()}}">
                        <h2 class="h4">{{$introBlogPosts[2]->name}}</h2></a>
                </header>
                <p>{{$introBlogPosts[2]->description}}</p>
                <footer class="post-footer d-flex align-items-center"><a href="{{$introBlogPosts[2]->getAuthorUrl()}}" class="author d-flex align-items-center flex-wrap">
                        <div class="avatar"><img src="{{$introBlogPosts[2]->users->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                        <div class="title"><span>{{$introBlogPosts[2]->users->name}}</span></div></a>
                    <div class="date"><i class="icon-clock"></i> {{Carbon\Carbon::parse($introBlogPosts[2]->created_at)->diffForHumans()}}</div>
                    <div class="comments"><i class="icon-comment"></i>{{$introBlogPosts[2]->comments->count()}}</div>
                </footer>
            </div>
        </div>
    </div>
    <div class="image col-lg-5"><img src="{{url('/themes/front/img/featured-pic-3.jpeg')}}" alt="..."></div>
</div>