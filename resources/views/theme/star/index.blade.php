@extends('theme.star.layouts.main')
@section('title') {{ get_option('hero_header_title', '') }} @endsection

@section('main')

<!-- Modern Header Section -->
<section class="py-5" id="header" style="background-color: #f9fafc;">
    <div class="bg-holder position-absolute w-100 h-100" 
         style="background-image:url(assets/img/gallery/header-bg-light.png); background-position:right top; background-size:cover; opacity:0.5; z-index:-1;">
    </div>

    <div class="container py-5">
        <div class="row align-items-center min-vh-75 min-vh-xl-100">
            <!-- Header Content -->
            <div class="col-md-6 text-md-start text-center mb-4 mb-md-0">
                <h1 class="display-4 fw-bold text-dark mb-3">
                    {{ get_option('hero_header_title') }}
                </h1>
                <p class="lead text-secondary">
                    {!! get_option('hero_header_description') !!}
                </p>

 

                <!-- Call-to-Action -->
                <div class="pt-4">
                    <a class="btn btn-lg btn-dark rounded-pill me-3 px-4 py-2 shadow" href="{{ url('shop') }}">Shop Now</a>

 <a class="btn btn-lg btn-dark rounded-pill me-3 px-4 py-2 shadow" href="{{ route('contacts') }}">Talk to an expert</a>
                </div>
            </div>

            <!-- Header Image -->
            <div class="col-md-6 text-center">
                <img class="img-fluid rounded shadow-lg" 
                     src="{{ get_option('hero_image', 'assets/img/default-placeholder.jpg') }}" 
                     alt="Hero Image" style="max-width: 90%; border-radius: 20px;">
            </div>
        </div>
    </div>

    <style>
        .highlight-box {
            background-color: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .highlight-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 1.5rem 3rem rgba(0, 0, 0, 0.1);
        }

        .bg-holder {
            opacity: 0.6;
        }

        .btn-primary {
            background-color: #0069d9;
            border: none;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .shadow-lg {
            box-shadow: 0 2rem 4rem rgba(0, 0, 0, 0.15);
        }
    </style>
</section>





<!-- Products Section -->
<section class="py-5" id="collections">
    <div class="container">
        <!-- Section Title -->
        <h2 class="text-center mb-5 fw-bold">
            {{ get_option('products_section_title', 'Our Stationery Collection') }}
        </h2>

        <div class="row g-4">
            <!-- Product Cards -->
            @foreach($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <!-- Product Image -->
                    <a href="{{ route('product_details', $product->slug) }}" class="text-decoration-none">
                        <div class="position-relative">
                            <img class="card-img-top rounded-top product-image" 
                                 src="{{ url('/') }}/storage/{{ $product->photo }}" 
                                 alt="Image of {{ $product->name }}" 
                                 loading="lazy">
                        </div>
                    </a>
                    <!-- Card Body -->
                    <div class="card-body text-center">
                        <a href="{{ route('product_details', $product->slug) }}" class="text-decoration-none">
                            <h5 class="fw-bold text-dark mb-2">KES {{ number_format($product->price, 2) }}</h5>
                            <h6 class="card-title text-dark mb-3">{{ $product->name }}</h6>
                        </a>
                        <a class="btn btn-outline-dark btn-sm rounded-pill" 
                           href="{{ route('product_details', $product->slug) }}">
                           View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

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
                        <p class="card-text">{{ $service->description }}</p>
                    </div>
                </div>
            </div>

            @endforeach

  
        </div>
    </div>
</section>

<!-- Homepage Description Section -->


<section class="post-content modern">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-7">
                <div class="post-content__content modern">
                   {!! get_option('homepage_description') !!}
                </div>
            </div>
        </div>
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






/* General Font Styling */
body {
    font-family: 'Roboto', Arial, sans-serif;
    font-size: 16px; /* Base font size */
    line-height: 1.75; /* Improve readability */
    color: #333; /* Use neutral color for text */
}

/* Header Section */
#header {
    padding: 5rem 0; /* Add vertical spacing */
    background-color: #f9fafc;
}

#header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #027333; /* Match theme color */
    margin-bottom: 1rem;
}

#header p {
    font-size: 1.125rem;
    color: #555;
    line-height: 1.8;
}

/* Buttons */
.btn-dark {
    background-color: #000000;
    border: none;
    color: #fff;
    font-size: 1rem;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

.btn-dark:hover {
    background-color: #000000;
    color: #fff;
    transform: translateY(-3px); /* Subtle hover effect */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Post Content */
.post-content__content {
    padding: 25px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    margin-top: 3rem;
}

.post-content__content img {
    display: block;
    max-width: 100%;
    height: auto;
    margin: 20px auto;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.post-content__content p {
    margin-bottom: 1.5rem;
    font-size: 1.125rem;
    line-height: 1.8;
}

/* Caption Styling */
.post-content__content .image-caption {
    font-size: 0.9rem;
    color: #777;
    margin-top: 10px;
    text-align: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    #header h1 {
        font-size: 2rem;
    }

    #header p {
        font-size: 1rem;
    }

    .btn-dark {
        font-size: 0.9rem;
        padding: 0.6rem 1.2rem;
    }

    .post-content__content {
        padding: 20px;
    }

    .container {
        padding: 15px;
    }
}

</style>

@endsection
