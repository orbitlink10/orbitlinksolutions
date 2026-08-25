@extends('theme.orbit.layouts.main')

@section('title', 'Shop by Brand')
@section('meta_description', 'Shop networking, CCTV, fibre, wireless, and PoE equipment by brand from Orbitlink Solutions in Kenya.')

@section('main')
<section class="trade-page-hero">
    <div class="container">
        <span class="trade-kicker">Brands</span>
        <h1>Shop by Brand</h1>
        <p>Browse products from brands currently available in the Orbitlink catalogue.</p>
    </div>
</section>

<section class="trade-benefits-section">
    <div class="container">
        <div class="brand-grid">
            @forelse($brands as $brand)
                <a href="{{ route('brands.show', $brand['slug']) }}" class="brand-tile">
                    <span class="brand-tile-name">{{ $brand['name'] }}</span>
                    <span class="brand-tile-count">{{ $brand['count'] }} {{ \Illuminate\Support\Str::plural('product', $brand['count']) }}</span>
                </a>
            @empty
                <div class="category-empty">
                    <i class="fas fa-tags"></i>
                    <h4>No brands found</h4>
                    <p>Add product brands in the product editor to populate this page.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
