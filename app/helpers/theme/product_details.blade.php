@extends('theme.layouts.main')
@section('title') {{ $product->name }} @endsection
@section('main')

    <!-- Page Header Start -->
    <section class="page-header">
        <div class="page-header-bg" style="background-image: url({{ asset('dark/assets/img/gallery/header-bg.png') }});">
        </div>
        <div class="container">
            <div class="page-header__inner text-center">
                <h1 class="">{{ $product->name }}</h1>
                <p class="">Your perfect solution for high-speed internet connectivity.</p>
            </div>
        </div>
    </section>
    <!-- Page Header End -->

    <!-- Product Details Start -->
    <section class="product-details py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4">
                    <div class="product-details__img">
                        <img src="/images?path={{ $product->photo }}" alt="{{ $product->name }}" class="img-fluid rounded shadow" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product-details__top">
                        <h3 class="product-details__title text-dark">{{ $product->name }}</h3>
                        <h4 class="product-details__price text-primary">KShs {{ number_format($product->price, 2) }}</h4>
                    </div>
                    <div class="product-details__review mb-3">
                        @for($i = 0; $i < 5; $i++)
                            <i class="fa fa-star text-warning"></i>
                        @endfor
                    </div>
                    <div class="product-details__content">
                        <p class="product-details__content-text">
                            @php
                                use Illuminate\Support\Str;
                            @endphp
                            {!! Str::words(strip_tags($product->description), 40, '...') !!}
                        </p>
                        <p class="product-details__availability text-muted">Available in store</p>
                    </div>
                    <div class="product-details__buttons mt-4">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-primary btn-lg">Buy Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details End -->

    <!-- Product Description Start -->
    <section class="product-description py-6 bg-light">
        <div class="container">
            <h3 class="product-description__title">Description</h3>
            <p>{!! $product->description !!}</p>
        </div>
    </section>
    <!-- Product Description End -->

@endsection
