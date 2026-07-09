@extends('theme.orbit.layouts.main')

@section('title')
    {{ $category->name }}
@endsection

@section('meta_description')
    {{ $category->meta_description }}
@endsection
@section('main')

@php
    $totalItems = method_exists($products, 'total') ? $products->total() : $products->count();
    $firstItem = method_exists($products, 'firstItem') ? ($products->firstItem() ?? 0) : ($products->count() > 0 ? 1 : 0);
    $lastItem = method_exists($products, 'lastItem') ? ($products->lastItem() ?? $products->count()) : $products->count();
@endphp

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
                                <img src="{{ $category->photo }}" alt="{{ $category->name }}">
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

<!-- Homepage Description Section -->
    <section class="py-5 category-description" id="homepage-description">
        <div class="container">
           {!! $category->description !!}
        </div>
    </section>
</div>
@endsection

