@extends('theme.electro.layouts.main')

@section('title')
    {{ $category->name }}
@endsection

@section('meta_description')
    {{ $category->meta_description }}
@endsection
@section('main')

 


<section class="py-0 pb-6" id="collections" style="margin-top: 50px; background-color: #f8f9fa;">
    <div class="container">
        <div class="row h-100">
            <div class="col-lg-7 mt-7 text-center text-lg-start" style="padding: 20px;">
                <h1 class="fs-3 fs-lg-5 lh-sm mb-4 text-black">{{ $category->name }}</h1>
                <p class="text-muted mb-5">{{ $category->meta_description }}</p>
            </div>
        </div>
    </div>
</section>

<section class="product-tabs section-padding position-relative wow fadeIn animated">
    <div class="bg-square"></div>
    <div class="container">
        <div class="tab-header">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one" type="button" role="tab" aria-controls="tab-one" aria-selected="true">Featured</button>
                </li>
            </ul>
            <a href="#" class="view-more d-none d-md-flex">View More<i class="fi-rs-angle-double-small-right"></i></a>
        </div>
        <!--End nav-tabs-->
        <div class="tab-content wow fadeIn animated" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                <div class="row product-grid-4">

                    @foreach($products as $ad)
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                        <div class="product-cart-wrap mb-30 h-100">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                    <a href="{{ route('product_details', $ad->slug) }}">
                                        <img class="default-img" src="{{ url('/') }}/storage/{{ $ad->photo }}" alt="{{ $ad->name }}" loading="lazy">
                                        <img class="hover-img" src="{{ url('/') }}/storage/{{ $ad->photo }}" alt="{{ $ad->name }}" loading="lazy">
                                    </a>
                                </div>
                            </div>
                            <div class="product-content-wrap">
                                @php
                                    $hasSale = isset($ad->marked_price) && $ad->has_price && $ad->marked_price > 0 && $ad->marked_price > ($ad->price ?? 0);
                                @endphp
                                @if($hasSale)
                                    <span class="badge-sale">-{{ discount($ad->id) }}%</span>
                                @endif
                                <div class="product-category">
                                    <a href="{{ route('view_product_category', ['slug' => category($ad->category_id)->slug]) }}">{{ category($ad->category_id)->name }}</a>
                                </div>
                                <h2><a href="{{ route('product_details', $ad->slug) }}">{{ \Illuminate\Support\Str::limit($ad->name, 40) }}</a></h2>
                                <div class="product-price">
                                    @if($ad->has_price)
                                    <span>{{ price($ad) }} </span>
                                    @endif
                                </div>
                                <div class="product-action-1 show mt-auto">
                                    <a aria-label="View more" class="action-btn hover-up" href="{{ route('product_details', $ad->slug) }}"><i class="fi-rs-shopping-bag-add"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach


                       <!-- Pagination -->
                <div class="mt-4">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>

                </div>
                <!--End product-grid-4-->
            </div>
            <!--End tab one (Featured)-->
        </div>

    </div>
</section>

<!-- Homepage Description Section -->
<section class="py-5" id="homepage-description">
    <div class="container">
       {!! $category->description !!}
    </div>
</section>
@endsection

