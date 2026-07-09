@extends('theme.star.layouts.main')

@section('title', "$post->meta_title")
@section('meta_description', $post->meta_description)
@section('social-meta')
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}" />
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $post->meta_title }}" />
    <meta property="og:description" content="{{ $post->meta_description }}" />
    <meta property="og:image" content="{{ $post->photo ? url('/') . '/storage/app/public/' . $post->photo : asset('default-image.jpg') }}" />
    <meta property="og:image:width" content="1478" />
    <meta property="og:image:height" content="1108" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="{{ get_option('site_name') }}" />
    <meta property="og:type" content="website" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="{{ url('/') }}" />
    <meta name="twitter:title" content="{{ $post->meta_title }}" />
    <meta name="twitter:description" content="{{ $post->meta_description }}" />
    <meta name="twitter:image" content="{{ $post->photo ? url('/') . '/storage/app/public/' . $post->photo : asset('default-image.jpg') }}" />

    @endsection



@section('main')


<section id="header" class="py-5" style="background-color: #f9fafc;">
    <div class="bg-holder position-absolute w-100 h-100"
         style="background-image: url(assets/img/gallery/header-bg-light.png); background-position: right top; background-size: cover; opacity: 0.5; z-index: -1;">
    </div>

    <div class="container py-5">
        <div class="row align-items-center min-vh-75 min-vh-xl-100">
            <!-- Header Content -->
            <div class="col-md-6 text-md-start text-center mb-4 mb-md-0">
                <h1 class="display-4 fw-bold text-dark mb-3">{{ $post->title }}</h1>
                <p class="lead text-secondary">{{ $post->meta_description }}</p>
                <div class="pt-4">
                    <a class="btn btn-lg btn-dark rounded-pill me-3 px-4 py-2 shadow" href="{{ url('shop') }}">Shop Now</a>
                    <a class="btn btn-lg btn-dark rounded-pill me-3 px-4 py-2 shadow" href="{{ route('contacts') }}">Talk to an Expert</a>
                </div>
            </div>

            <!-- Header Image -->
            <div class="col-md-6 text-center">
                <img class="img-fluid rounded shadow-lg"
                     src="{{ url('/') }}/storage/{{ $post->photo }}"
                     alt="{{ $post->title }} image" style="max-width: 90%; border-radius: 20px;">
            </div>
        </div>
    </div>
</section>

<?php 
$products = \App\Models\Product::limit(4)->get();
?>

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
                                 src="/images?path={{ $product->photo }}" 
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




<section class="post-content modern">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-7">
                <div class="post-content__content modern">
                    {!! $post->description !!}
                </div>
            </div>
        </div>
    </div>
</section>


<style type="text/css">
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
