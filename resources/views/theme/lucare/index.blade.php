@extends('theme.lucare.layouts.main')
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


<section class="featured position-relative py-5">
    <div class="container">
        <div class="row g-4">
            @foreach($categories->take(18) as $category)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('view_product_category', ['slug' => $category->slug]) }}" class="text-decoration-none text-dark">
                        <div class="card category-card border-0 shadow-sm h-100">
                            <div class="card-img-top position-relative overflow-hidden">
                                <img src="{{ $category->photo }}" 
                                     alt="{{ $category->name }}"
                                     class="img-fluid w-100 h-100 object-fit-cover">
                                <div class="overlay d-flex align-items-center justify-content-center">
                                    <h5 class="text-white fw-bold m-0">{{ $category->name }}</h5>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h6 class="card-title mb-0">{{ $category->name }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <!-- View All Categories Button -->
        <div class="text-center mt-4">
            <a href="{{ route('allcategories') }}" class="btn btn-primary">View All Categories</a>
        </div>
    </div>
</section>



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





<!-- Services Section -->

@if($medias2->count()>0)
<section class="bg-light py-5" id="medias">
    <div class="container">
  

        <!-- Carousel -->
        <div id="mediaCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @foreach($medias2->chunk(4) as $key => $mediaChunk)
                    <div class="carousel-item @if($key == 0) active @endif">
                        <div class="row">
                            @foreach($mediaChunk as $media)
                                <div class="col-md-3">
                                    <div class="media-card2" data-bs-toggle="modal" data-bs-target="#imageModal1" onclick="showImagea('{{ $media->file_path }}')">
                                        <img class="d-block w-100" src="{{ $media->file_path }}" alt="Installation">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#mediaCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mediaCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
@endif
<!-- Modal -->
<div class="modal fade" id="imageModal1" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Full View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage2" src="" alt="Full View" class="img-fluid">
            </div>
        </div>
    </div>
</div>


<!-- JavaScript -->
<script>
    function showImagea(imagePath) {
        const modalImage = document.getElementById('modalImage2');
        modalImage.src = imagePath;
    }
</script>

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




@if($medias->count()>0)
<!-- Services Section -->
<section class="bg-light py-5" id="medias">
    <div class="container">
        <h2 class="text-center mb-5">Our Recent Installations</h2>

        <!-- Carousel -->
        <div id="mediaCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @foreach($medias->chunk(4) as $key => $mediaChunk)
                    <div class="carousel-item @if($key == 0) active @endif">
                        <div class="row">
                            @foreach($mediaChunk as $media)
                                <div class="col-md-3">
                                    <div class="media-card" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('{{ $media->file_path }}')">
                                        <img class="d-block w-100" src="{{ $media->file_path }}" alt="Installation">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#mediaCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mediaCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
@endif

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Full View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Full View" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- CSS for hover and enlarge effect -->
<style>
    .media-card {
        overflow: hidden;
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .media-card img {
        transition: transform 0.3s ease;
        object-fit: cover;
        height: 500px;
    }

        .media-card2 img {
        transition: transform 0.3s ease;
        object-fit: cover;
        height: 300px;
    }

    .media-card:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    .media-card:hover img {
        transform: scale(1.1);
    }
</style>

<!-- JavaScript -->
<script>
    function showImage(imagePath) {
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imagePath;
    }
</script>







<!-- Services Section -->
<section class="bg-light py-5" id="services">
    <div class="container">
        <h2 class="text-center mb-5">Our Services</h2>
        <div class="row">

@foreach($services as $service)

            <!-- Sell Starlink Kits -->
            <div class="col-sm-6 col-md-4 mb-4">
                <div class="card shadow-sm border-light text-center h-100 rounded-lg">
                    <div class="card-body">
                        <h4 class="card-title text-dark">{{ $service->name }}</h4>
                        <p class="card-text">{!! $service->meta_description !!}</p>


                          <a href="{{ route('service_single', ['slug' =>$service->slug ?? '0' ]) }}">View more</a>


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

<style type="text/css">
    #homepage-description {
    overflow: hidden; /* Prevent content from overflowing the container */
    word-wrap: break-word; /* Handle long words or links */
    max-width: 100%; /* Ensure content does not exceed the container width */
    padding: 1rem; /* Add padding for better readability */
    box-sizing: border-box; /* Include padding and borders in width/height calculations */
}

#homepage-description .container {
    margin: 0 auto; /* Center the content horizontally */
    max-width: 1200px; /* Restrict the maximum width for better readability */
}

@media (max-width: 768px) {
    #homepage-description .container {
        padding: 0 1rem; /* Add padding for smaller screens */
    }
}

</style>

@endsection
