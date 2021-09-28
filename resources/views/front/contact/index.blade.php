@extends('front._layout.layout')

@section('seo_title', __('Contact Form'))

@section('content')

<section style="background: url(themes/front/img/hero.jpg); background-size: cover; background-position: center center" class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Have an interesting news or idea? Don't hesitate to contact us!</h1>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="col-lg-8"> 
            <div class="container">
                @include('front.contact.partials.contact_form')
            </div>
        </main>
        <aside class="col-lg-4">
            <!-- Widget [Contact Widget]-->
            <div class="widget categories">
                <header>
                    <h3 class="h6">Contact Info</h3>
                    <div class="item d-flex justify-content-between">
                        <span>15 Yemen Road, Yemen</span>
                        <span><i class="fa fa-map-marker"></i></span>
                    </div>
                    <div class="item d-flex justify-content-between">
                        <span>(020) 123 456 789</span>
                        <span><i class="fa fa-phone"></i></span>
                    </div>
                    <div class="item d-flex justify-content-between">
                        <span>info@company.com</span>
                        <span><i class="fa fa-envelope"></i></span>
                    </div>
                </header>

            </div>
            <div class="widget latest-posts">
                <header>
                    <h3 class="h6">@lang('Latest Posts')</h3>
                </header>
                <div class="blog-posts">
                    @foreach($blogs as $blog)
                    <a href="{{$blog->getFrontUrl()}}">
                        <div class="item d-flex align-items-center">
                            <div class="image"><img src="{{$blog->getPhoto1ThumbUrl()}}" alt="..." class="img-fluid"></div>
                            <div class="title"><strong>{{$blog->name}}</strong>
                                <div class="d-flex align-items-center">
                                    <div class="views"><i class="icon-eye"></i> {{$blog->views}}</div>
                                    <div class="comments"><i class="icon-comment"></i>{{$blog->comments->count()}}</div>
                                </div>
                            </div>
                        </div></a>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
</div>

@endsection