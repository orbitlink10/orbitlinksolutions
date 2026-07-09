@extends('theme.layouts.main')
@section('title') {{ $product->name }} @endsection
@section('main')

    <!--Page Header Start-->
    <section class="page-header">
        <div class="page-header-bg" style="background-image: url({{ asset('dark/assets/img/gallery/header-bg.png') }})">
        </div>
        <div class="container">
            <div class="page-header__inner">
              
          
            </div>
        </div>
    </section>
    <!--Page Header End-->

    <!--Product Details Start-->
    <section class="product-details py-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product-details__img">
                        <img src="/images?path={{ $product->photo }}" alt="{{ $product->name }}" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product-details__top">
                        <h3 class="product-details__title">{{ $product->name }}</h3>
                        <h3 class="product-details__title"><span>KShs {{ $product->price }}</span></h3>
                    </div>
                    <div class="product-details__review">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <div class="product-details__content">
                        <p class="product-details__content-text1">
                            @php
                                use Illuminate\Support\Str;
                            @endphp
                            {!! Str::words(strip_tags($product->description), 40, '...') !!}
                        </p>
                        <p class="product-details__content-text2">Available in store</p>
                    </div>
                    <div class="product-details__buttons">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-outline-light">Buy Now</button>
                        </form>
                    </div>
       
                </div>
            </div>
        </div>
    </section>
    <!--Product Details End-->

    <!--Product Description Start-->
    <section class="product-description py-6 bg-dark">
        <div class="container">
            <h3 class="product-description__title text-light">Description</h3>
            {!! $product->description !!}
        </div>
    </section>
    <!--Product Description End-->

@endsection
