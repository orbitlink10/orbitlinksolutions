@extends('theme.gamun.layouts.main')

@section('title', $product->name)

@section('main')
<div class="container py-5 px-4 px-md-5">
    <h1 class="mb-4 text-success fw-bold">{{ $product->name }}</h1>

    <div class="row g-4">
        {{-- Product Image --}}
        <div class="col-md-6">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="img-fluid rounded shadow-sm w-100" 
                     style="max-height: 500px; object-fit: contain;">
            @else
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded shadow-sm" 
                     style="height: 300px; font-size: 1.2rem;">
                    No Image Available
                </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div class="col-md-6">
            <h4 class="mb-3">Category: 
                <span class="text-success">{{ $product->category->name ?? 'Uncategorized' }}</span>
            </h4>

            <div class="border rounded p-3 bg-light">
                <h5 class="fw-semibold mb-3">Cost Breakdown</h5>
                <ul class="list-unstyled mb-0">
                    <li><strong>Material Cost:</strong> KES {{ number_format($product->material_cost ?? 0, 2) }}</li>
                    <li><strong>Labour Cost:</strong> KES {{ number_format($product->labour_cost ?? 0, 2) }}</li>
                    <li><strong>Total Cost:</strong> <span class="text-success fw-bold">KES {{ number_format($product->total_cost ?? 0, 2) }}</span></li>
                </ul>
            </div>
        </div>
    </div>

    <a href="{{ route('welding-products.index') }}" class="btn btn-outline-secondary mt-5">
        <i class="bi bi-arrow-left"></i> Back to Products
    </a>
</div>
@endsection
