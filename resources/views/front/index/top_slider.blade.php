<div id="index-slider" class="owl-carousel">
    @foreach($sliders as $slider)
    <section style="background: url('<?php echo $slider->getPhotoUrl(); ?>'); background-size: cover; background-position: center center" class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <h1>{{$slider->title}}</h1>
                    <a href="{{$slider->url}}" class="hero-link">Discover More</a>
                </div>
            </div>
        </div>
    </section>
    @endforeach
</div>