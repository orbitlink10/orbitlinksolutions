@extends('theme.layouts.main')
@section('title') Buy Starlink Kit  @endsection
@section('main')

<section class="py-0 pb-6" id="collections" style="margin-top: 50px; padding: 20px;">
    <div class="container">
        <div class="row h-100">
            <div class="col-lg-7 mt-7" style="padding: 20px;">
                <h1 class="fs-3 fs-lg-5 lh-sm mb-0">Starlink Kit</h1>
            </div>
            <div class="col-12">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-latest" role="tabpanel" aria-labelledby="nav-latest-tab">
                        <div class="carousel slide" id="carouselLatest" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="row h-100 align-items-center">
                                    @foreach($products as $product)
                                    <div class="col-sm-6 col-md-4 mb-3 mb-md-0">
                                        <div class="card bg-black text-white p-6 pb-8">
                                            <img class="card-img" src="/images?path={{ $product->photo }}" alt="{{ $product->name }}" />
                                            <div class="card-img-overlay bg-dark-gradient d-flex flex-column-reverse align-items-center">
                                                <h6 class="text-primary">KES {{ $product->price }}</h6>
                                                <h4 class="text-light">{{ $product->name }}</h4>
                                            </div>
                                            <a class="stretched-link" href="{{ route('product_details', $product->slug) }}"></a>
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
