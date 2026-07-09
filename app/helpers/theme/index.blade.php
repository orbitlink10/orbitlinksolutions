@extends('theme.layouts.main')

@section('main')
<!-- Header Section -->
<section class="py-0" id="header">
    <div class="bg-holder" style="background-image:url(assets/img/gallery/header-bg-light.png);background-position:right top;background-size:cover;"></div>

    <div class="container">
        <div class="row align-items-center min-vh-75 min-vh-xl-100">
            <div class="col-md-8 col-lg-6 text-md-start text-center">
                <h1 class="display-3 lh-sm text-uppercase text-dark font-weight-bold">Starlink <br class="d-none d-xxl-block" /> Kenya</h1>
                <p class="lead text-dark">Your trusted provider of Starlink kits and professional installation services. Enjoy high-quality satellite internet solutions for fast and reliable connectivity across the country.</p>
                <div class="pt-4">
                    <a class="btn btn-lg btn-outline-dark me-3" href="#collections">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Store Information Section -->
<section class="bg-light py-8 pt-0" id="store">
    <div class="container-lg">
        <div class="row flex-center">
            <div class="col-sm-10 col-md-8 text-center">
                <h2 class="text-dark mb-4">Why Choose Starlink Kenya?</h2>
                <p class="text-dark mb-4">We provide high-speed satellite internet solutions, offering reliable equipment, expert installation, and dedicated customer support, ensuring connectivity even in remote areas.</p>
                <div class="carousel slide carousel-fade" id="carouselExampleFade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="assets/img/gallery/carousel-1.jpg" class="d-block w-100" alt="Fast Satellite Internet">
                            <div class="carousel-caption d-none d-md-block">
                                <h5 class="text-white">Fast Satellite Internet Across Kenya</h5>
                                <p class="text-white">Enhancing connectivity for households and businesses.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/gallery/carousel-2.jpg" class="d-block w-100" alt="Professional Installation">
                            <div class="carousel-caption d-none d-md-block">
                                <h5 class="text-white">Professional Installation Services</h5>
                                <p class="text-white">Expert installation for a hassle-free experience.</p>
                            </div>
                        </div>
                        <!-- Additional carousel items can be added here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-5" id="collections">
    <div class="container">
        <h2 class="text-center mb-5">Our Products</h2>
        <div class="row">
            @foreach($products as $product)
            <div class="col-sm-6 col-md-4 mb-4">
                <div class="card shadow-sm border-light h-100">
                    <div class="card-img-wrapper">
                        <img class="card-img-top" src="/images?path={{ $product->photo }}" alt="{{ $product->name }}" />
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-dark">{{ $product->name }}</h5>
                        <h6 class="text-primary">KES {{ number_format($product->price, 2) }}</h6>
                        <p class="card-text">Ready to experience high-speed internet across Kenya? Get your Starlink Kit today!</p>
                        <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-dark">Buy Now</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

<style>
/* Additional CSS for Image Fitting */
.card-img-wrapper {
    height: 200px; /* Set a fixed height for the wrapper */
    overflow: hidden; /* Hide overflow to prevent images from spilling out */
    position: relative; /* Make sure position is relative for absolute positioning of img */
}

.card-img-top {
    position: absolute; /* Position absolutely to fill the wrapper */
    top: 50%; /* Center vertically */
    left: 50%; /* Center horizontally */
    transform: translate(-50%, -50%); /* Translate back to center */
    min-height: 100%; /* Ensure it covers the full height */
    min-width: 100%; /* Ensure it covers the full width */
    object-fit: cover; /* Ensure the image covers the area without stretching */
    display: block; /* Ensure image behaves like a block element */
}
</style>
