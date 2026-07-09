@extends('theme.branding.layouts.main')

@section('title') Design Your Own Products @endsection
@section('meta_description', get_option('hero_header_description'))

@section('main')

<style>
    .uniform-height {
        height: 350px; /* Adjust height as per your design */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .product-content-wrap {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
</style>

<section class="py-0 pb-6" id="design-products" style="margin-top: 50px; background-color: #f8f9fa;">
    <div class="container">
        <div class="row h-100">
            <div class="col-lg-7 mt-7 text-center text-lg-start" style="padding: 20px;">
                <h1 class="fs-3 fs-lg-5 lh-sm mb-4 text-black">Design Your Own Product</h1>
                <p class="text-muted mb-5">
                    Select the type of product you want to design and customize. Choose from a variety of options—from T-shirts to business cards—and start creating your unique design today.
                </p>
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
                    <button class="nav-link active" id="product-tab" data-bs-toggle="tab" data-bs-target="#product-tab-content" type="button" role="tab" aria-controls="product-tab-content" aria-selected="true">Available Products</button>
                </li>
            </ul>
            <a href="#" class="view-more d-none d-md-flex">View More<i class="fi-rs-angle-double-small-right"></i></a>
        </div>
        <!--End nav-tabs-->
        <div class="tab-content wow fadeIn animated" id="myTabContent">
            <div class="tab-pane fade show active" id="product-tab-content" role="tabpanel" aria-labelledby="product-tab">
                <div class="row product-grid-4">

                    @foreach($designs as $design)
                    <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                        <div class="product-cart-wrap mb-30 uniform-height">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                    <a href="{{ route('designs.design', $design->id) }}">
                                        <img class="default-img" src="{{ $design->image_url }}" alt="{{ $design->name }}">
                                        <img class="hover-img" src="{{ $design->image_url }}" alt="{{ $design->name }}">
                                    </a>
                                </div>
                            </div>
                            <div class="product-content-wrap">
                                <h2>
                                    <a href="{{ route('designs.design', $design->id) }}">
                                        {{ \Illuminate\Support\Str::limit($design->name, 40) }}
                                    </a>
                                </h2>
                                <div class="product-action-1 show">
                                    <a aria-label="Select Product" class="action-btn hover-up" href="{{ route('designs.design', $design->id) }}">
                                        <i class="fi-rs-shopping-bag-add"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                <!--End product-grid-4-->
            </div>
            <!--End tab-pane-->
        </div>
    </div>
</section>
@endsection
