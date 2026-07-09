@extends('theme.layouts.main')
@section('title') Buy Starlink Kit @endsection
@section('main')

<section class="py-0 pb-6" id="collections" style="margin-top: 50px; background-color: #f8f9fa;">
    <div class="container">
        <div class="row h-100">
            <div class="col-lg-7 mt-7 text-center text-lg-start" style="padding: 20px;">
                <h1 class="fs-3 fs-lg-5 lh-sm mb-4 text-black">Starlink Kit</h1>
                <p class="text-muted mb-5">Explore our range of Starlink Kits designed to provide you with high-speed internet connectivity anywhere in Kenya. Choose the perfect kit for your needs.</p>
            </div>
            <div class="col-12">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-latest" role="tabpanel" aria-labelledby="nav-latest-tab">
                        <div class="carousel slide" id="carouselLatest" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="row h-100 align-items-center">
                                    @foreach($products as $product)
                                    <div class="col-sm-6 col-md-4 mb-3 mb-md-0">
                                        <div class="card shadow-sm border-light">
                                            <img class="card-img-top" src="/images?path={{ $product->photo }}" alt="{{ $product->name }}" />
                                            <div class="card-body text-center" style="background-color: #ffffff;">
                                                <h6 class="text-primary fw-bold">KES {{ number_format($product->price, 2) }}</h6>
                                                <h4 class="card-title text-black">{{ $product->name }}</h4>
                                                <p class="card-text">Get connected with reliable high-speed internet solutions.</p>
                                                <div class="d-flex justify-content-center mt-3">
                                                    <a class="btn btn-outline-primary me-2" href="{{ route('product_details', $product->slug) }}">View Details</a>
                                                    <form action="{{ route('cart.add') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <button type="submit" class="btn btn-primary">Buy Now</button>
                                                    </form>
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
        </div>
    </div>
</section>

@endsection
