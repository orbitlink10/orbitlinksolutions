@extends('theme.orbit.layouts.main')

@section('title', "$post->meta_title")
@section('meta_description', $post->meta_description)

@push('meta')
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $post->meta_title }}" />
    <meta property="og:description" content="{{ $post->meta_description }}" />
    <meta property="og:image" content="{{ $post->photo ? url('/') . '/storage/' . $post->photo : asset('default-image.jpg') }}" />
    <meta property="og:image:width" content="1478" />
    <meta property="og:image:height" content="1108" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="{{ get_option('site_name', 'Orbitlink Solutions') }}" />
    <meta property="og:type" content="article" />
    <meta property="article:published_time" content="{{ optional($post->created_at)->toIso8601String() }}" />
    <meta property="article:modified_time" content="{{ optional($post->updated_at)->toIso8601String() }}" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="{{ url('/') }}" />
    <meta name="twitter:title" content="{{ $post->meta_title }}" />
    <meta name="twitter:description" content="{{ $post->meta_description }}" />
    <meta name="twitter:image" content="{{ $post->photo ? url('/') . '/storage/' . $post->photo : asset('default-image.jpg') }}" />
    @php
        $siteName = get_option('site_name', 'Orbitlink Solutions');
        $rawLogo = get_option('logo');
        $siteLogo = null;
        if (!empty($rawLogo)) {
            $isAbs = \Illuminate\Support\Str::startsWith($rawLogo, ['http://', 'https://', '//']);
            $siteLogo = $isAbs ? $rawLogo : url($rawLogo);
        }
        $postImage = $post->photo ? url('/') . '/storage/' . $post->photo : null;
        $articleSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'description' => strip_tags((string) $post->meta_description),
            'image' => $postImage ? [$postImage] : null,
            'datePublished' => optional($post->created_at)->toIso8601String(),
            'dateModified' => optional($post->updated_at)->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => $siteName,
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $siteName,
                'logo' => $siteLogo ? [
                    '@type' => 'ImageObject',
                    'url' => $siteLogo,
                ] : null,
            ],
            'mainEntityOfPage' => url()->current(),
        ];
    @endphp
    <script type="application/ld+json">
        @json($articleSchema)
    </script>
@endpush

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

                @if($post->photo)

                <img class="img-fluid rounded shadow-lg"
                     src="{{ url('/') }}/storage/{{ $post->photo }}"
                     alt="{{ $post->title }} image" style="max-width: 90%; border-radius: 20px;">
                     @else

                     <img class="img-fluid rounded shadow-lg"
                     src="{{ get_option('hero_image', 'assets/img/default-placeholder.jpg') }}"
                     alt="{{ $post->title }} image" style="max-width: 90%; border-radius: 20px;">
 
                     @endif
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
            @foreach($products as $ad)
           <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                        <div class="product-cart-wrap mb-30 uniform-height">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                    <a href="{{ route('product_details', $ad->slug) }}">
                                        <img class="default-img" src="{{ url('/') }}/storage/{{ $ad->photo }}" alt="">
                                        <img class="hover-img" src="{{ url('/') }}/storage/{{ $ad->photo }}" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="product-content-wrap">
                                <div class="product-category">
                                    <a href="{{ route('view_product_category', ['slug' => category($ad->category_id)->slug]) }}">{{ category($ad->category_id)->name }}</a>
                                </div>
                                <h2><a href="{{ route('product_details', $ad->slug) }}">{{ \Illuminate\Support\Str::limit($ad->name, 40) }}</a></h2>
                                <div class="product-price">
                                    @if($ad->has_price)
                                    <span>{{ price($ad) }} </span>
                                    @endif
                                </div>
                                <div class="product-action-1 show">
                                    <a aria-label="View more" class="action-btn hover-up" href="{{ route('product_details', $ad->slug) }}"><i class="fas fa-shopping-bag"></i></a>
                                </div>
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


<section class="py-5" id="homepage-description">
    <div class="container">
     {!! $post->description !!}
    </div>
</section>


@endsection
