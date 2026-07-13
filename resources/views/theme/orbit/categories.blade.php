@extends('theme.orbit.layouts.main')

@php
    $totalItems = method_exists($products, 'total') ? $products->total() : $products->count();
    $firstItem = method_exists($products, 'firstItem') ? ($products->firstItem() ?? 0) : ($products->count() > 0 ? 1 : 0);
    $lastItem = method_exists($products, 'lastItem') ? ($products->lastItem() ?? $products->count()) : $products->count();
    $currentPage = method_exists($products, 'currentPage') ? $products->currentPage() : 1;
    $categoryUrl = route('view_product_category', ['slug' => $category->slug]);
    $canonicalUrl = $currentPage > 1 && method_exists($products, 'url') ? $products->url($currentPage) : $categoryUrl;
    $baseTitle = $category->name;
    $pageTitle = $currentPage > 1 ? $baseTitle . ' - Page ' . $currentPage : $baseTitle;
    $metaDescription = trim((string) $category->meta_description);

    if ($metaDescription === '') {
        $metaDescription = 'Shop ' . $category->name . ' products in Kenya with fast delivery, genuine warranty, and expert support from Orbitlink Solutions.';
    }

    $metaDescription = \Illuminate\Support\Str::limit(strip_tags($metaDescription), 155, '');
    $categoryImage = !empty($category->photo) ? uploaded_image_url($category->photo) : null;
    $shareImage = $categoryImage ?: asset('assets/images/orbitlinks-logo.webp');
    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => url('/'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => 'Shop',
                'item' => url('shop'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $category->name,
                'item' => $categoryUrl,
            ],
        ],
    ];
    $itemListElements = [];

    foreach ($products as $index => $product) {
        $productItem = [
            '@type' => 'Product',
            'name' => $product->name,
            'url' => route('product_details', $product->slug),
            'image' => product_image_url($product),
        ];

        if ($product->has_price && $product->price !== null) {
            $productItem['offers'] = [
                '@type' => 'Offer',
                'priceCurrency' => 'KES',
                'price' => (string) $product->price,
                'availability' => 'https://schema.org/InStock',
                'url' => route('product_details', $product->slug),
            ];
        }

        $itemListElements[] = [
            '@type' => 'ListItem',
            'position' => $firstItem + $index,
            'item' => $productItem,
        ];
    }

    $itemListSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'name' => $category->name,
        'url' => $canonicalUrl,
        'numberOfItems' => $totalItems,
        'itemListElement' => $itemListElements,
    ];
    $faqSchema = null;

    if ($category->slug === 'starlink-kenya-prices') {
        $faqSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => [
                [
                    '@type' => 'Question',
                    'name' => 'How much is a Starlink kit in Kenya?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Starlink kit pricing in Kenya depends on the model, stock, accessories, and installation needs. Check the product prices on this category page or contact Orbitlink Solutions for a current quote.',
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Does Orbitlink Solutions install Starlink in Kenya?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Yes. Orbitlink Solutions supplies Starlink kits and accessories and can help with installation, mounting, alignment, WiFi setup, and support for homes and businesses in Kenya.',
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Are Starlink monthly subscription prices included in the kit price?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'No. Hardware and installation are separate from Starlink monthly service plans. Subscription plans can change, so confirm the active plan price during activation or with Orbitlink Solutions before purchase.',
                    ],
                ],
            ],
        ];
    }
@endphp

@section('title', $pageTitle)
@section('meta_description', $metaDescription)
@section('canonical', $canonicalUrl)
@section('og_title', $pageTitle . ' | Orbitlink Solutions')
@section('og_description', $metaDescription)
@section('og_image', $shareImage)
@section('og_url', $canonicalUrl)
@section('twitter_title', $pageTitle . ' | Orbitlink Solutions')
@section('twitter_description', $metaDescription)
@section('twitter_image', $shareImage)

@push('meta')
    @if($products->previousPageUrl())
        <link rel="prev" href="{{ $currentPage === 2 ? $categoryUrl : $products->previousPageUrl() }}">
    @endif
    @if($products->nextPageUrl())
        <link rel="next" href="{{ $products->nextPageUrl() }}">
    @endif
    <script type="application/ld+json">
        {!! json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    <script type="application/ld+json">
        {!! json_encode($itemListSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    @if($faqSchema)
        <script type="application/ld+json">
            {!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endif
@endpush

@section('main')

<div class="category-page">
    <section class="category-hero" id="category-hero">
        <div class="container">
            <div class="category-hero-grid">
                <div class="category-hero-copy">
                    <nav class="breadcrumb category-breadcrumb">
                        <a href="{{ url('/') }}">Home</a>
                        <span>/</span>
                        <a href="{{ url('shop') }}">Shop</a>
                        <span>/</span>
                        <span class="active">{{ $category->name }}</span>
                    </nav>
                    <span class="category-kicker">Category</span>
                    <h1 class="category-title">{{ $category->name }}</h1>
                    <p class="category-subtitle">{{ $category->meta_description }}</p>
                    <div class="category-hero-actions">
                        <a href="#category-products" class="btn btn-accent">Shop products</a>
                        <a href="{{ route('allcategories') }}" class="btn btn-outline-secondary">All categories</a>
                    </div>
                    <div class="category-hero-chips">
                        <span class="category-chip"><i class="fas fa-shield-alt"></i> Genuine warranty</span>
                        <span class="category-chip"><i class="fas fa-truck"></i> Fast delivery</span>
                        <span class="category-chip"><i class="fas fa-headset"></i> Expert support</span>
                    </div>
                </div>
                <div class="category-hero-card">
                    <div class="category-hero-card-body">
                        <div class="category-hero-stat">
                            <span class="stat-label">Products</span>
                            <span class="stat-value">{{ number_format($totalItems) }}</span>
                        </div>
                        <div class="category-hero-image">
                            @if(!empty($category->photo))
                                <img src="{{ uploaded_image_url($category->photo) }}" alt="{{ $category->name }}" width="240" height="240">
                            @else
                                <div class="category-hero-image-fallback">
                                    <i class="fas fa-camera"></i>
                                </div>
                            @endif
                        </div>
                        <p class="category-hero-note">Shop curated {{ $category->name }} gear with trusted brands and flexible budgets.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="category-products section-padding" id="category-products">
        <div class="container">
            <div class="category-products-header">
                <div>
                    <span class="category-section-kicker">Featured</span>
                    <h2>Top picks in {{ $category->name }}</h2>
                    <p>Compare price points, specs, and bundles tailored to Kenyan homes and businesses.</p>
                </div>
                <div class="category-products-actions">
                    <span class="category-products-count">
                        Showing {{ number_format($firstItem) }}-{{ number_format($lastItem) }} of {{ number_format($totalItems) }} items
                    </span>
                    <a href="{{ route('allcategories') }}" class="btn btn-outline-secondary btn-sm">All categories</a>
                </div>
            </div>
            <div class="row product-grid-4 g-4">
                @forelse($products as $ad)
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="product-cart-wrap h-100">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                    <a href="{{ route('product_details', $ad->slug) }}">
                                        <img class="default-img" src="{{ product_image_url($ad) }}" alt="{{ $ad->name }}" width="600" height="600" loading="lazy">
                                        <img class="hover-img" src="{{ product_image_url($ad) }}" alt="{{ $ad->name }}" width="600" height="600" loading="lazy">
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
                                <h3><a href="{{ route('product_details', $ad->slug) }}">{{ \Illuminate\Support\Str::limit($ad->name, 40) }}</a></h3>
                                <div class="product-price">
                                    @if($ad->has_price)
                                        <span>{{ price($ad) }} </span>
                                    @endif
                                </div>
                                <div class="product-action-1 show mt-auto">
                                    <a aria-label="View more" class="action-btn hover-up" href="{{ route('product_details', $ad->slug) }}"><i class="fas fa-shopping-bag"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="category-empty">
                            <i class="fas fa-box-open"></i>
                            <h4>No products available</h4>
                            <p>We are restocking this category. Please check back soon.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="category-pagination">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>

    <section class="py-5 category-description" id="category-description">
        <div class="container">
           {!! $category->description !!}
        </div>
    </section>
</div>
@endsection
