@extends('theme.orbit.layouts.main')

@section('title', 'Shop')
@section('meta_description', get_option('hero_header_description'))

@section('main')
@php
    $totalItems = method_exists($products, 'total') ? $products->total() : $products->count();
    $firstItem = method_exists($products, 'firstItem') ? ($products->firstItem() ?? 0) : ($products->count() > 0 ? 1 : 0);
    $lastItem = method_exists($products, 'lastItem') ? ($products->lastItem() ?? $products->count()) : $products->count();
    $search = request('q');
    $selectedCategory = $activeCategory ? $activeCategory->slug : request('category');
    $sort = request('sort', 'newest');
    $minPrice = request('min_price');
    $maxPrice = request('max_price');
    $availability = request('availability');
    $saleOnly = request()->boolean('sale');
    $currency = get_option('currency_symbol', 'KES');
    $rangeMin = $priceRange && $priceRange->min_price !== null ? number_format($priceRange->min_price, 0) : null;
    $rangeMax = $priceRange && $priceRange->max_price !== null ? number_format($priceRange->max_price, 0) : null;
@endphp

<section class="shop-hero">
    <div class="container">
        <div class="shop-hero-grid">
            <div class="shop-hero-copy">
                <span class="shop-kicker">Shop</span>
                <h1 class="shop-title">Our Products</h1>
                <p class="shop-subtitle">Explore our curated range of networking, Starlink, CCTV, WiFi, and ICT gear.</p>
            </div>
            <div class="shop-hero-panel">
                <form action="{{ url('shop') }}" method="get" class="shop-search">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="q" class="form-control" placeholder="Search products, brands, or keywords" value="{{ $search }}">
                        <button class="btn btn-accent" type="submit">Search</button>
                    </div>
                    @if($selectedCategory)
                        <input type="hidden" name="category" value="{{ $selectedCategory }}">
                    @endif
                    @if($minPrice !== null && $minPrice !== '')
                        <input type="hidden" name="min_price" value="{{ $minPrice }}">
                    @endif
                    @if($maxPrice !== null && $maxPrice !== '')
                        <input type="hidden" name="max_price" value="{{ $maxPrice }}">
                    @endif
                    @if($availability)
                        <input type="hidden" name="availability" value="{{ $availability }}">
                    @endif
                    @if($saleOnly)
                        <input type="hidden" name="sale" value="1">
                    @endif
                    @if($sort)
                        <input type="hidden" name="sort" value="{{ $sort }}">
                    @endif
                </form>
                <div class="shop-hero-summary">
                    <div class="summary-item">
                        <span class="summary-label">Results</span>
                        <span class="summary-value">{{ number_format($totalItems) }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Categories</span>
                        <span class="summary-value">{{ number_format($categories->count()) }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Price range</span>
                        <span class="summary-value">
                            @if($rangeMin && $rangeMax)
                                {{ $currency }} {{ $rangeMin }} - {{ $currency }} {{ $rangeMax }}
                            @else
                                Varies
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="shop-layout section-padding">
    <div class="container">
        <div class="row g-4">
            <aside class="col-lg-3">
                <div class="d-lg-none mb-3">
                    <button class="btn btn-outline-secondary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#shopFilters" aria-expanded="false" aria-controls="shopFilters">
                        Filters
                    </button>
                </div>
                <div class="collapse d-lg-block" id="shopFilters">
                    <form action="{{ url('shop') }}" method="get" class="shop-filter-card">
                        <div class="filter-header">
                            <h5>Filters</h5>
                            <a class="filter-reset" href="{{ url('shop') }}">Reset</a>
                        </div>
                        <input type="hidden" name="q" value="{{ $search }}">
                        <input type="hidden" name="sort" value="{{ $sort }}">
                        <div class="filter-group">
                            <span class="filter-title">Category</span>
                            <div class="filter-options">
                                <label class="filter-option">
                                    <input type="radio" name="category" value="" {{ $selectedCategory ? '' : 'checked' }}>
                                    <span>All categories</span>
                                </label>
                                @foreach($categories as $category)
                                    <label class="filter-option">
                                        <input type="radio" name="category" value="{{ $category->slug }}" {{ $selectedCategory === $category->slug ? 'checked' : '' }}>
                                        <span>{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="filter-group">
                            <span class="filter-title">Price range ({{ $currency }})</span>
                            <div class="filter-range">
                                <input type="number" class="form-control" name="min_price" placeholder="{{ $rangeMin ? 'Min ' . $rangeMin : 'Min' }}" value="{{ $minPrice }}">
                                <input type="number" class="form-control" name="max_price" placeholder="{{ $rangeMax ? 'Max ' . $rangeMax : 'Max' }}" value="{{ $maxPrice }}">
                            </div>
                        </div>
                        <div class="filter-group">
                            <span class="filter-title">Availability</span>
                            <div class="filter-options">
                                <label class="filter-option">
                                    <input type="radio" name="availability" value="" {{ !$availability ? 'checked' : '' }}>
                                    <span>All</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="availability" value="in" {{ $availability === 'in' ? 'checked' : '' }}>
                                    <span>In stock</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="availability" value="out" {{ $availability === 'out' ? 'checked' : '' }}>
                                    <span>Out of stock</span>
                                </label>
                            </div>
                        </div>
                        <div class="filter-group">
                            <label class="filter-toggle">
                                <input type="checkbox" name="sale" value="1" {{ $saleOnly ? 'checked' : '' }}>
                                <span>On sale items only</span>
                            </label>
                        </div>
                        <div class="filter-actions">
                            <button type="submit" class="btn btn-accent w-100">Apply filters</button>
                            <a href="{{ url('shop') }}" class="btn btn-outline-secondary w-100">Clear all</a>
                        </div>
                    </form>
                </div>
            </aside>
            <div class="col-lg-9">
                <div class="shop-toolbar">
                    <div class="shop-results">
                        <span>Showing {{ number_format($firstItem) }}-{{ number_format($lastItem) }} of {{ number_format($totalItems) }} items</span>
                        @if($search)
                            <span class="shop-results-query">for "{{ $search }}"</span>
                        @endif
                    </div>
                    <form class="shop-sort" method="get" action="{{ url('shop') }}">
                        <input type="hidden" name="q" value="{{ $search }}">
                        @if($selectedCategory)
                            <input type="hidden" name="category" value="{{ $selectedCategory }}">
                        @endif
                        @if($minPrice !== null && $minPrice !== '')
                            <input type="hidden" name="min_price" value="{{ $minPrice }}">
                        @endif
                        @if($maxPrice !== null && $maxPrice !== '')
                            <input type="hidden" name="max_price" value="{{ $maxPrice }}">
                        @endif
                        @if($availability)
                            <input type="hidden" name="availability" value="{{ $availability }}">
                        @endif
                        @if($saleOnly)
                            <input type="hidden" name="sale" value="1">
                        @endif
                        <label class="shop-sort-label" for="sortSelect">Sort by</label>
                        <select id="sortSelect" class="form-select form-select-sm" name="sort" onchange="this.form.submit()">
                            <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                            <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                        </select>
                    </form>
                </div>
                <div class="row product-grid-4 g-4">
                    @forelse($products as $ad)
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
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
                                        @else
                                            <span class="text-muted">Request quote</span>
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
                            <div class="category-empty">
                                <i class="fas fa-search"></i>
                                <h4>No products found</h4>
                                <p>Try adjusting your search or filters.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="category-pagination mt-4">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
