@extends('theme.orbit.layouts.main')

@section('title', "$post->meta_title")
@section('meta_description', $post->meta_description)

@push('meta')
    @php
        $siteName = get_option('site_name', 'Orbitlink Solutions');
        $absoluteUrl = function ($value) {
            if (empty($value)) {
                return null;
            }

            return \Illuminate\Support\Str::startsWith($value, ['http://', 'https://', '//'])
                ? $value
                : url($value);
        };
        $postImageUrl = uploaded_image_url($post->photo, asset('assets/images/placeholder.svg'));
        $postImageAbsolute = $absoluteUrl($postImageUrl);
        $siteLogoUrl = uploaded_image_url(get_option('logo'), asset('favicon.ico'));
        $siteLogoAbsolute = $absoluteUrl($siteLogoUrl);
    @endphp

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $post->meta_title }}" />
    <meta property="og:description" content="{{ $post->meta_description }}" />
    <meta property="og:image" content="{{ $postImageAbsolute }}" />
    <meta property="og:image:width" content="1478" />
    <meta property="og:image:height" content="1108" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="{{ $siteName }}" />
    <meta property="og:type" content="article" />
    <meta property="article:published_time" content="{{ optional($post->created_at)->toIso8601String() }}" />
    <meta property="article:modified_time" content="{{ optional($post->updated_at)->toIso8601String() }}" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="{{ url('/') }}" />
    <meta name="twitter:title" content="{{ $post->meta_title }}" />
    <meta name="twitter:description" content="{{ $post->meta_description }}" />
    <meta name="twitter:image" content="{{ $postImageAbsolute }}" />
    @php
        $articleSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'description' => strip_tags((string) $post->meta_description),
            'image' => $postImageAbsolute ? [$postImageAbsolute] : null,
            'datePublished' => optional($post->created_at)->toIso8601String(),
            'dateModified' => optional($post->updated_at)->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => $siteName,
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $siteName,
                'logo' => $siteLogoAbsolute ? [
                    '@type' => 'ImageObject',
                    'url' => $siteLogoAbsolute,
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
    .page-hero-compact {
        padding: 34px 0 38px;
        background-color: #f9fafc;
    }
    .page-hero-compact .hero-row {
        min-height: 0;
    }
    .page-hero-compact .hero-title {
        line-height: 1.08;
        margin-bottom: 1rem;
    }
    .page-hero-compact .hero-description {
        margin-bottom: 0;
    }
    .page-hero-compact .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        padding-top: 1rem;
    }
    .page-hero-compact .hero-actions .btn {
        margin-right: 0 !important;
    }
    .page-hero-compact .hero-image {
        width: 100%;
        max-height: 520px;
        object-fit: contain;
        object-position: center;
        image-rendering: auto;
    }
    .page-hero-compact .hero-visual {
        max-width: 640px;
        margin-left: auto;
        background: #ffffff;
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 22px 52px rgba(15, 23, 42, 0.12);
    }
    .page-products-grid .product-cart-wrap {
        height: 100%;
        min-height: 0;
        background: #ffffff;
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
    }
    .page-products-grid .product-img-action-wrap {
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        padding: 14px;
    }
    .page-products-grid .product-img {
        aspect-ratio: 4 / 3;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        border-radius: 10px;
        overflow: hidden;
    }
    .page-products-grid .product-img a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }
    .page-products-grid .product-img img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        image-rendering: auto;
    }
    .page-products-grid .product-content-wrap {
        padding: 16px;
    }
    .page-section-compact {
        padding-top: 2.5rem !important;
        padding-bottom: 2.5rem !important;
    }

    @media (max-width: 767.98px) {
        .page-hero-compact {
            padding: 24px 0 30px;
        }
        .page-hero-compact .hero-title {
            font-size: 2.4rem;
        }
        .page-hero-compact .hero-image {
            max-height: 420px;
        }
        .page-hero-compact .hero-visual {
            margin: 0 auto;
            padding: 14px;
        }
        .page-section-compact {
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }
    }
</style>
<section id="header" class="page-hero-compact">
    <div class="bg-holder position-absolute w-100 h-100"
         style="background-image: url(assets/img/gallery/header-bg-light.png); background-position: right top; background-size: cover; opacity: 0.5; z-index: -1;">
    </div>

    <div class="container">
        <div class="row align-items-center hero-row">
            <!-- Header Content -->
            <div class="col-md-6 text-md-start text-center mb-4 mb-md-0">
                <h1 class="display-4 fw-bold text-dark hero-title">{{ $post->title }}</h1>
                <p class="lead text-secondary hero-description">{{ $post->meta_description }}</p>
                <div class="hero-actions">
                    <a class="btn btn-lg btn-dark rounded-pill me-3 px-4 py-2 shadow" href="{{ url('shop') }}">Shop Now</a>
                    <a class="btn btn-lg btn-dark rounded-pill me-3 px-4 py-2 shadow" href="{{ route('contacts') }}">Talk to an Expert</a>
                </div>
            </div>

            <!-- Header Image -->
            <div class="col-md-6 text-center">

                @if($post->photo)

                <div class="hero-visual">
                    <img class="img-fluid hero-image"
                         src="{{ uploaded_image_url($post->photo) }}"
                         alt="{{ $post->alter_text ?: $post->title . ' image' }}"
                         loading="eager"
                         decoding="async"
                         fetchpriority="high">
                </div>
                     @else

                     <div class="hero-visual">
                         <img class="img-fluid hero-image"
                             src="{{ uploaded_image_url(get_option('hero_image'), asset('assets/images/placeholder.svg')) }}"
                             alt="{{ $post->title }} image"
                             loading="eager"
                             decoding="async"
                             fetchpriority="high">
                     </div>
 
                     @endif
            </div>
        </div>
    </div>
</section>

@php
    $selectedProductCategory = $post->product_category_id
        ? \App\Models\Category::find($post->product_category_id)
        : null;
    $productsQuery = \App\Models\Product::with(['mediaFiles', 'category'])->where('product_type', 'product')->orderBy('id', 'desc');
    if ($selectedProductCategory) {
        $productsQuery->where('category_id', $selectedProductCategory->id);
    }
    $products = $productsQuery->limit(4)->get();
@endphp

<!-- Products Section -->
<section class="py-5 page-section-compact" id="collections">
    <div class="container">
        <!-- Section Title -->
        <h2 class="text-center mb-5 fw-bold">
            {{ $selectedProductCategory ? $selectedProductCategory->name : get_option('products_section_title', 'Featured Products') }}
        </h2>

        <div class="row g-4 page-products-grid">
            <!-- Product Cards -->
            @forelse($products as $ad)
            @php
                $productImage = product_image_url($ad, uploaded_image_url($ad->photo));
            @endphp
           <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                        <div class="product-cart-wrap mb-30 uniform-height">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                    <a href="{{ route('product_details', $ad->slug) }}">
                                        <img class="default-img"
                                             src="{{ $productImage }}"
                                             alt="{{ $ad->name }}"
                                             loading="lazy"
                                             decoding="async">
                                        <img class="hover-img"
                                             src="{{ $productImage }}"
                                             alt="{{ $ad->name }}"
                                             loading="lazy"
                                             decoding="async">
                                    </a>
                                </div>
                            </div>
                            <div class="product-content-wrap">
                                <div class="product-category">
                                    @if(category($ad->category_id))
                                        <a href="{{ route('view_product_category', ['slug' => category($ad->category_id)->slug]) }}">{{ category($ad->category_id)->name }}</a>
                                    @endif
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
            @empty
                <div class="col-12">
                    <p class="text-center text-muted mb-0">No products found in this category yet.</p>
                </div>
            @endforelse
        </div>

        <!-- View All Products Button -->
        @if($selectedProductCategory)
            <div class="text-center mt-4">
                <a href="{{ route('view_product_category', ['slug' => $selectedProductCategory->slug]) }}" class="btn btn-dark btn-lg rounded-pill px-4">
                    View All {{ $selectedProductCategory->name }}
                </a>
            </div>
        @else
            <div class="text-center mt-4">
                <a href="/shop" class="btn btn-dark btn-lg rounded-pill px-4">
                    View All Products
                </a>
            </div>
        @endif
    </div>
</section>


<section class="py-5 page-section-compact" id="homepage-description">
    <div class="container">
     {!! rich_content_html($post->description) !!}
    </div>
</section>


@endsection
