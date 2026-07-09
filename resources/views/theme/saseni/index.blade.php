@extends('theme.branding.layouts.main') 

@section('title') 
    {{ get_option('hero_header_title') }} 
@endsection

@section('meta_description', get_option('hero_header_description'))

@section('main')

<!-- Hero Slider -->
<section class="home-slider position-relative pt-50">
    <div class="hero-slider-1 dot-style-1 dot-style-1-position-1">
        @foreach($sliders as $slider)
        <div class="single-hero-slider single-animation-wrap">
            <div class="container">
                <div class="row align-items-center slider-animated-1">
                    <div class="col-lg-6 col-md-6">
                        <div class="hero-slider-content-2">
<h1 class="animated fadeInUp delay-0-4 fw-900 text-brand">{{ $slider->h1_title }}</h1>
<p class="animated fadeInUp delay-0-8">{{ $slider->description }}</p>
                            <a class="animated btn btn-brush btn-brush-3 fadeInUp delay-1-0" href="{{ $slider->button_url }}"> 
                                {{ $slider->button_text }} 
                            </a>

                                 <a class="animated btn btn-brush btn-brush-3 fadeInUp delay-1-0" href="{{ route('design') }}"> 
                                Design Your Own 
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="single-slider-img single-slider-img-1 text-center">
                            <img class="animated fadeInRight delay-0-8" src="{{ $slider->img_url }}" alt="Hero Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="slider-arrow hero-slider-1-arrow"></div>
</section>


    <section class="featured section-padding position-relative">
            <div class="container">
                <div class="row">
@foreach($categories->take(6) as $category)
    <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
        <a href="{{ route('view_product_category', ['slug' => $category->slug]) }}">
            <div class="banner-features wow fadeIn animated hover-up">
                <img src="{{ $category->photo }}" alt="{{ $category->name }}">
                <h4 class="bg-1">{{ $category->name }}</h4>
            </div>
        </a>
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

<!-- Custom CSS for advanced UI effects -->
<style>
    /* Uniform height for product cards */
    .uniform-height {
        height: 350px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .uniform-height:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 25px rgba(0,0,0,0.1);
    }
    /* Product card content styling */
    .product-content-wrap h2 a {
        color: #333;
        transition: color 0.3s ease;
    }
    .product-content-wrap h2 a:hover {
        color: #d9534f;
    }
    /* Button styling */
    .btn-brush {
        background: linear-gradient(45deg, #d9534f, #f0ad4e);
        border: none;
        color: #fff;
        padding: 12px 30px;
        font-size: 16px;
        border-radius: 30px;
        transition: background 0.3s ease, box-shadow 0.3s ease;
    }
    .btn-brush:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    /* Section titles */
    section h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #333;
    }
    /* Testimonials card */
    #testimonials .card {
        border: none;
        transition: transform 0.3s ease;
    }
    #testimonials .card:hover {
        transform: translateY(-10px);
    }
    /* Carousel controls customization */
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        filter: invert(50%);
    }
</style>

<!-- Product Tabs Section -->
<section class="product-tabs section-padding position-relative wow fadeIn animated">
    <div class="bg-square"></div>
    <div class="container">
        <div class="tab-header d-flex align-items-center justify-content-between mb-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one" type="button" role="tab" aria-controls="tab-one" aria-selected="true">
                        {{ get_option('products_section_title', 'Our Stationery Collection') }}
                    </button>
                </li>
            </ul>
            <a href="{{ url('shop') }}" class="view-more d-none d-md-flex align-items-center">
                View More <i class="fi-rs-angle-double-small-right ms-2"></i>
            </a>
        </div>
        <!-- End nav-tabs-->
        <div class="tab-content wow fadeIn animated" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                <div class="row product-grid-4">
                    @foreach($products as $ad)
                    <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                        <div class="product-cart-wrap mb-30 uniform-height">
                            <div class="product-img-action-wrap position-relative">
                                <div class="product-img product-img-zoom">
                                    <a href="{{ route('product_details', $ad->slug) }}">
                                        <img class="default-img img-fluid" src="{{ url('/') }}/storage/{{ $ad->photo }}" alt="{{ $ad->name }}">
                                        <img class="hover-img img-fluid" src="{{ url('/') }}/storage/{{ $ad->photo }}" alt="{{ $ad->name }}">
                                    </a>
                                </div>
                            </div>
                            <div class="product-content-wrap p-3">
                                <div class="product-category mb-2">
                                    <a href="{{ route('view_product_category', ['slug' => category($ad->category_id)->slug]) }}">
                                        {{ category($ad->category_id)->name }}
                                    </a>
                                </div>
                                <h2 class="fs-6 mb-2">
                                    <a href="{{ route('product_details', $ad->slug) }}">
                                        {{ \Illuminate\Support\Str::limit($ad->name, 40) }}
                                    </a>
                                </h2>
                                <div class="product-price mb-2">
                                    @if($ad->has_price)
                                    <span class="fw-bold">{{ price($ad) }}</span>
                                    @endif
                                </div>
                                <div class="product-action-1">
                                    <a aria-label="View more" class="action-btn hover-up" href="{{ route('product_details', $ad->slug) }}">
                                        <i class="fi-rs-shopping-bag-add"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- End product-grid-4-->
            </div>
        </div>
        <!-- End tab-content-->

        <!-- View All Products Button -->
        <div class="text-center mt-4">
            <a href="/shop" class="btn btn-dark btn-lg rounded-pill px-4">
                View All Products
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
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
                            <div class="card shadow-sm h-100 rounded-lg p-3">
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
        <div class="row justify-content-center text-center">
            <div class="col-sm-10 col-md-8">
                <h2 class="text-dark mb-4">
                    {{ get_option('why_choose_title', 'Why Choose Pepasa Stationers?') }}
                </h2>
                <p class="text-dark lead">
                    {{ get_option('why_choose_description', 'At Pepasa Stationers, we offer a wide range of high-quality stationery products for individuals, businesses, and educational institutions.') }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="bg-light py-4" id="services">
    <div class="container">
        <!-- Section Title -->
        <div class="text-center mb-4">
            <h2 class="fw-bold text-success">Our Services</h2>
            <p class="text-muted mb-3">Discover our wide range of branding and printing solutions.</p>
        </div>

        <!-- Services Grid -->
        <div class="row row-cols-2 row-cols-md-3 g-3">
            @foreach($services as $service)
            <div class="col">
                <div class="card border-0 shadow-sm h-100 rounded-3">
                    <!-- Image -->
                    <img src="{{ $service->image_url }}" class="card-img-top img-fluid" alt="{{ $service->name }}">

                    <!-- Card Body -->
                    <div class="card-body text-center">
                        <h5 class="card-title text-dark fw-bold">{{ $service->name }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($service->meta_description, 100) }}</p>

                        <!-- CTA Button -->
                        <a href="{{ route('service_single', ['slug' => $service->slug ?? '0']) }}" class="btn btn-success btn-sm">View More</a>
                    </div>
                </div>
            </div>
            @endforeach
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
