@extends('theme.star.layouts.main')

@section('title') 
    Products Listing 
@endsection

@section('main')
<section class="py-0 pb-6" id="collections" style="margin-top: 50px; background-color: #f8f9fa;">
    <div class="container">
        <div class="row h-100">
            <div class="col-lg-7 mt-7 text-center text-lg-start" style="padding: 20px;">
                <h1 class="fs-3 fs-lg-5 lh-sm mb-4 text-black">Our Products</h1>
                <p class="text-muted mb-5">Explore our diverse range of products designed to meet your needs and preferences.</p>
            </div>

            <div class="col-12">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-latest" role="tabpanel" aria-labelledby="nav-latest-tab">
                        <div class="row">
                            @foreach($products as $product)
                            <div class="col-sm-6 col-md-3 mb-3 d-flex align-items-stretch">
                                <div class="card shadow-sm border-light product-card">

                                    <div class="card-img-container">
                                        <img class="card-img-top product-image" src="{{ url('/') }}/storage/{{ $product->photo }}" alt="{{ $product->name }}" />
                                    </div>

                                    <div class="card-body text-center">
                                        <h6 class="text-primary fw-bold">KES {{ number_format($product->price, 2) }}</h6>
                                        <h4 class="card-title text-black">{{ $product->name }}</h4>
                                        <p class="card-text">Get connected with reliable high-speed internet solutions.</p>
                                        <div class="d-flex justify-content-center mt-3">
                                            <a class="btn btn-outline-primary me-2" href="{{ route('product_details', $product->slug) }}">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    /* Ensure all product cards have a uniform height */
    .product-card {
        height: 100%; /* Stretch cards to equal height */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Image Container for uniformity */
    .card-img-container {
        height: 200px; /* Fix image container height */
        overflow: hidden; /* Hide overflow to maintain aspect ratio */
    }

    /* Product Image Uniformity */
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Ensure the image covers the container */
    }

    /* Center the content inside the card body */
    .product-card .card-body {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
    }

    /* Subtle Shadow for Polished Look */
    .card-img-top {
        border-bottom: 1px solid #eaeaea;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Text Alignment for Consistency */
    .card-title {
        font-size: 1rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .card-text {
        font-size: 0.9rem;
        color: #6c757d;
    }

    /* Button Hover Effect */
    .btn-outline-primary:hover {
        background-color: #007bff;
        color: #fff;
    }
</style>
@endsection
