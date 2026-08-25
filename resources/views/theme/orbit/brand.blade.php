@extends('theme.orbit.layouts.main')

@section('title', $label . ' Kenya')
@section('meta_description', 'Shop ' . $label . ' products in Kenya from Orbitlink Solutions. Installer support, Nairobi pickup, and nationwide delivery available.')

@section('main')
<section class="trade-page-hero">
    <div class="container">
        <nav class="breadcrumb category-breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span>/</span>
            <a href="{{ route('brands.index') }}">Brands</a>
            <span>/</span>
            <span class="active">{{ $label }}</span>
        </nav>
        <span class="trade-kicker">Brand</span>
        <h1>{{ $label }} Kenya</h1>
        <p>Shop available {{ $label }} equipment for installers, technicians, and project buyers in Kenya.</p>
    </div>
</section>

<section class="category-products section-padding">
    <div class="container">
        <div class="category-products-header">
            <div>
                <span class="category-section-kicker">Products</span>
                <h2>{{ $label }} products</h2>
                <p>Compare available products and request installer pricing where applicable.</p>
            </div>
            <a href="{{ route('send-boq.show') }}" class="btn btn-outline-secondary btn-sm">Request Project Quote</a>
        </div>
        <div class="row product-grid-4 g-4">
            @foreach($products as $ad)
                @include('theme.orbit.partials.product_card', ['ad' => $ad])
            @endforeach
        </div>
        <div class="category-pagination">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
    </div>
</section>
@endsection
