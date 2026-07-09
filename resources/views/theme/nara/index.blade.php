@extends('theme.nara.layouts.main')
@section('title') {{ get_option('hero_header_title') }} @endsection
@section('meta_description', get_option('hero_header_description'))
@section('main')



 <section class="home-slider position-relative pt-50">
            <div class="hero-slider-1 dot-style-1 dot-style-1-position-1">
@foreach($sliders as $slider)
                <div class="single-hero-slider single-animation-wrap">
                    <div class="container">
                        <div class="row align-items-center slider-animated-1">
                            <div class="col-lg-5 col-md-6">
                                <div class="hero-slider-content-2">
                                    <h4 class="animated">{{ $slider->h4_title }}</h4>
                                    <h2 class="animated fw-900">{{ $slider->h2_title }}</h2>
                                    <h1 class="animated fw-900 text-brand">{{ $slider->h1_title }}</h1>
                                    <p class="animated">{{ $slider->description }}</p>
                                    <a class="animated btn btn-brush btn-brush-3" href="{{ $slider->button_url }}"> {{ $slider->button_text }} </a>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-6">
                                <div class="single-slider-img single-slider-img-1">
                                    <img class="animated slider-1-1" src="{{ $slider->img_url }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

@endforeach
               
            </div>
            <div class="slider-arrow hero-slider-1-arrow"></div>
        </section>




<style>
    .uniform-height {
        height: 350px; /* Adjust height as per your design */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .product-content-wrap {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
</style>

        <section class="product-tabs section-padding position-relative wow fadeIn animated">
            <div class="bg-square"></div>
            <div class="container">
                <div class="tab-header">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">

                        <li class="nav-item" role="presentation">

<button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one" type="button" role="tab" aria-controls="tab-one" aria-selected="true">  {{ get_option('products_section_title', 'Our Stationery Collection') }}
</button>

                        </li>
                 
                    </ul>
                    <a href="{{ url('shop') }}" class="view-more d-none d-md-flex">View More<i class="fi-rs-angle-double-small-right"></i></a>
                </div>
                <!--End nav-tabs-->
                <div class="tab-content wow fadeIn animated" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                        <div class="row product-grid-4">


       @foreach($products as $ad)

                                     <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                        <div class="product-cart-wrap mb-30 uniform-height">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                    <a href="{{ route('product_details', $ad->slug) }}">
                                        <img class="default-img" src="{{ url('/') }}/storage/{{ $ad->photo }}" alt="">
                                        <img class="hover-img" src="{{ url('/') }}/storage/{{ $ad->photo }}" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="product-content-wrap">
                                <div class="product-category">
                                    <a href="{{ route('view_product_category', ['slug' => category($ad->category_id)->slug]) }}">{{ category($ad->category_id)->name }}</a>
                                </div>
                                <h2><a href="{{ route('product_details', $ad->slug) }}">{{ \Illuminate\Support\Str::limit($ad->name, 40) }}</a></h2>
                                <div class="product-price">
                                    @if($ad->has_price)
                                    <span>{{ price($ad) }} </span>
                                    @endif
                                </div>
                                <div class="product-action-1 show">
                                    <a aria-label="View more" class="action-btn hover-up" href="{{ route('product_details', $ad->slug) }}"><i class="fi-rs-shopping-bag-add"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
       @endforeach

                        </div>
                        <!--End product-grid-4-->
                    </div>
                    <!--En tab one (Featured)-->

    
                    <!--En tab three (New added)-->
                </div>
                <!--End tab-content-->

                   <!-- View All Products Button -->
        <div class="text-center mt-4">
            <a href="/shop" class="btn btn-dark btn-lg rounded-pill px-4">
                View All Products
            </a>
        </div>
            </div>
        </section>




<section class="py-5 bg-light" id="testimonials">
    <div class="container">
        <h2 class="text-center mb-5">What Our Clients Say</h2>

        <!-- Testimonials Carousel -->
        <div id="testimonialsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @foreach($testimonials->chunk(3) as $key => $testimonialChunk)
                    <div class="carousel-item @if($key == 0) active @endif">
                        <div class="row">
                            @foreach($testimonialChunk as $testimonial)
                                <div class="col-md-4">
                                    <div class="card shadow-sm border-light h-100 rounded-lg p-3">
                                        <div class="card-body text-center">
                                            <blockquote class="blockquote mb-0">
                                                <p class="font-italic">"{{ $testimonial->description }}"</p>
                                                <footer class="blockquote-footer mt-3">{{ $testimonial->name }}</footer>
                                            </blockquote>
                                            <p class="text-warning mt-2">⭐⭐⭐⭐⭐</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>



<!-- Store Information Section -->
<section class="bg-light py-8 pt-0" id="store">
    <div class="container-lg">
        <div class="row flex-center">
            <div class="col-sm-12 col-md-12 text-center">
                <h2 class="text-dark mb-4">{{ get_option('why_choose_title', 'Why Choose Pepasa Stationers?') }}</h2>
                <p class="text-dark mb-4">
                    {{ get_option('why_choose_description', 'At Pepasa Stationers, we offer a wide range of high-quality stationery products for individuals, businesses, and educational institutions.') }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Homepage Description Section -->
<section class="py-5" id="homepage-description">
    <div class="container">
       {!! get_option('homepage_description') !!}
    </div>
</section>


@endsection
