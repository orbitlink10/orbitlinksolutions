@extends('theme.lopezspace.layouts.main') 

@section('title') 
    {{ get_option('hero_header_title') }}
@endsection

@section('meta_description', get_option('hero_header_description'))

@section('main')

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            @foreach($sliders as $slider)
                <div class="col-lg-6">
                    <h4>{{ $slider->h4_title }}</h4>
                    <h2>{{ $slider->h2_title }}</h2>
                    <h1>{{ $slider->h1_title }}</h1>
                    <p>{{ $slider->description }}</p>
                    <a class="btn btn-hero" href="{{ $slider->button_url }}">
                        {{ $slider->button_text }}
                    </a>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="{{ $slider->img_url }}" alt="Hero Image" class="img-fluid">
                </div>
            @endforeach
        </div>
    </div>
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
                    <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one" type="button" role="tab" aria-controls="tab-one" aria-selected="true">Featured products</button>
                </li>
            </ul>
            <a href="#" class="view-more d-none d-md-flex">View More<i class="fi-rs-angle-double-small-right"></i></a>
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
            <!--End tab one (Featured)-->
        </div>

    </div>
</section>

<!-- Testimonials Section -->
<section id="testimonials">
    <div class="container">
        <h2>What Our Clients Say</h2>
        <div id="testimonialsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @foreach($testimonials->chunk(3) as $key => $testimonialChunk)
                <div class="carousel-item @if($key == 0) active @endif">
                    <div class="row">
                        @foreach($testimonialChunk as $testimonial)
                        <div class="col-md-4 mb-4">
                            <div class="card p-4">
                                <div class="card-body text-center">
                                    <blockquote class="blockquote">
                                        <p class="mb-3">"{{ $testimonial->description }}"</p>
                                        <footer class="blockquote-footer">{{ $testimonial->name }}</footer>
                                    </blockquote>
                                    <p class="text-warning">⭐⭐⭐⭐⭐</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" 
                    data-bs-target="#testimonialsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" 
                    data-bs-target="#testimonialsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<!-- Store Information Section (Why Choose Us) -->
<section id="store">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-sm-10 col-md-8">
                <h2>{{ get_option('why_choose_title', 'Why Choose Our Beauty Shop?') }}</h2>
                <p class="lead">
                    {{ get_option('why_choose_description', 'We offer a wide range of high-quality beauty products tailored to enhance your natural glow.') }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services">
    <div class="container">
        <h2>Our Services</h2>
        <p class="text-center text-muted mb-4">
            Explore our specialized beauty and wellness services.
        </p>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($services as $service)
            <div class="col">
                <div class="card h-100">
                    <!-- Service Image -->
                    <img src="{{ $service->image_url }}" class="card-img-top img-fluid" 
                         alt="{{ $service->name }}">
                    <!-- Card Body -->
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $service->name }}</h5>
                        <p class="card-text text-muted small">
                            {{ Str::limit($service->meta_description, 100) }}
                        </p>
                        <a href="{{ route('service_single', ['slug' => $service->slug ?? '0']) }}" 
                           class="btn btn-accent btn-sm">
                            View More
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Homepage Description Section -->
<section id="homepage-description">
    <div class="container">
       {!! get_option('homepage_description') !!}
    </div>
</section>

@endsection
