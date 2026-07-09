@extends('theme.gamun.layouts.main')
@section('title', $product->name)
@section('meta_description', $product->meta_description)

@section('main')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ url('/') }}" rel="nofollow">Home</a>
            <span></span>
            <a href="{{ route('view_product_category', ['slug' => App\Models\Category::find($product->category_id)->slug]) }}">
                      {{ App\Models\Category::find($product->category_id)->name }}
            </a>
            <span></span> {{ $product->name }}
        </div>
    </div>
</div>

<section class="mt-50 mb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="product-detail accordion-detail">
                    <div class="row mb-50">
                        <div class="col-md-6">
    <div class="detail-gallery uniform-height-gallery">
        <span class="zoom-icon"><i class="fi-rs-search"></i></span>
        <!-- MAIN SLIDES -->
        <div class="product-image-slider">
            @if($mediafiles->count() > 0)
                @foreach($mediafiles as $media)
                    <figure class="border-radius-10">
                        <img src="{{ $media->file_path }}" alt="{{ $product->name }}" loading="lazy" decoding="async">
                    </figure>
                @endforeach
            @else
                <figure class="border-radius-10">
                    <img src="{{ url('/') }}/storage/{{ $product->photo }}" alt="{{ $product->name }}" loading="lazy" decoding="async">
                </figure>
            @endif
        </div>
        <!-- THUMBNAILS -->
        <div class="slider-nav-thumbnails pl-15 pr-15">
            @foreach($mediafiles as $media)
                <div><img src="{{ $media->file_path }}" alt="{{ $product->name }}" loading="lazy" decoding="async"></div>
            @endforeach
        </div>
    </div>
</div>


                        <div class="col-md-6">
                            <div class="detail-info">
                                <h2 class="title-detail">{{ $product->name }}</h2>
                                <div class="product-detail-rating">
                                    <div class="pro-details-brand">
                                        <span>Category: <a href="{{ route('view_product_category', ['slug' => App\Models\Category::find($product->category_id)->slug]) }}">     {{ App\Models\Category::find($product->category_id)->name }}</a></span>
                                    </div>
                                </div>
                                <div class="clearfix product-price-cover">
                                    <div class="product-price primary-color float-left">
    @if($product->has_price)
                                        <ins><span class="text-brand">KES {{ number_format($product->price, 2) }}</span></ins>
                                        <ins><span class="old-price font-md ml-15">KES {{ number_format($product->price * 1.25, 2) }}</span></ins>
                                        <span class="save-price font-md color3 ml-15">25% Off</span>

                                        @endif
                                    </div>
                                </div>
                                <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                                <div class="short-desc mb-30">
                                    {!! Str::words(strip_tags($product->description), 40, '...') !!}
                                </div>
                                <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                                <div class="detail-extralink">
                                    <div class="product-extra-link2">
                                        @if($product->quantity > 0)
                                            @if($product->has_price)

                                             
                                                <form action="{{ route('cart.add') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                                       <div class="product-extra-link2">
                                                    <button type="submit" class="button button-add-to-cart">Add to
                                                    cart</button>

                                                     <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                    href="{{ route('wishlist.store', $product->id)}}"><i class="fi-rs-heart"></i></a>

                                                     </div>
                                                </form>


                                                                                               
                                               
                                            @else
                                                <button type="button" class="btn btn-dark btn-lg" data-bs-toggle="modal" data-bs-target="#quoteModal">Get Quote</button>
                                            @endif
                                        @else
                                            <button type="button" class="btn btn-dark btn-lg" data-bs-toggle="modal" data-bs-target="#notifyModal">Notify Me</button>
                                        @endif
                                        @include('theme.lucare.modals.notify')
                                        @include('theme.lucare.modals.quote')
                                    </div>
                                </div>
                                <ul class="product-meta font-xs color-grey mt-50">
                                    @if($product->has_price)
                                    <li>Availability:<span class="in-stock text-success ml-5">{{ $product->quantity > 0 ? 'Available in store' : 'Out of stock' }}</span></li>

                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-style3">
                        <ul class="nav nav-tabs text-uppercase">
                            <li class="nav-item">
                                <a class="nav-link active" id="Description-tab" data-bs-toggle="tab" href="#Description">Description</a>
                            </li>
                        </ul>
                        <div class="tab-content shop_info_tab entry-main-content">
                            <div class="tab-pane fade show active" id="Description">
                                <div>{!! $product->description !!}</div>
                            </div>
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
  /* Unify gallery heights for a clean look */
  .uniform-height-gallery .product-image-slider img { width: 100%; height: clamp(320px, 52vh, 560px); object-fit: cover; }
  .slider-nav-thumbnails img { width: 90px; height: 90px; object-fit: cover; border-radius: 10px; }
  @media (max-width: 576px) { .slider-nav-thumbnails img { width: 70px; height: 70px; } }
  .detail-info .title-detail { font-size: 1.5rem; }
  .detail-info .product-price .text-brand { color: var(--brand); }
  .detail-info .save-price { font-weight: 600; }
  .product-meta li { padding: .25rem 0; }
</style>
@endsection

@section('scripts')
@endsection
