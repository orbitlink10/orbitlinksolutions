@extends('theme.gamun.layouts.main')

@section('title') Welding Products in Category: {{ $category->name }} @endsection

@section('main')
<div class="container py-5">

    <h1 class="mb-5 text-center fw-bold text-success">
        Welding Products in Category: <span class="text-success">{{ $category->name }}</span>
    </h1>

    {{-- Categories List --}}
    <div class="mb-5 text-center">
        <h5 class="mb-3 fw-semibold">Filter by Categories</h5>
        <div class="d-inline-flex flex-wrap gap-2 justify-content-center">
            <a href="{{ route('welding-products.index') }}" 
               class="btn btn-sm btn-outline-success rounded-pill {{ !request()->segment(3) ? 'active fw-bold' : '' }}">
                All
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('welding-products.category', $cat->slug) }}" 
                   class="btn btn-sm btn-outline-success rounded-pill {{ $cat->id === $category->id ? 'active fw-bold' : '' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Products Grid --}}
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card shadow-sm border-0 rounded-4 h-100 product-card transition-shadow">
                    @if($product->image)
                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $product->id }}">
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 class="card-img-top rounded-top" alt="{{ $product->name }}"
                                 style="width: 100%; height: auto; object-fit: contain; transition: transform 0.3s ease;">
                        </a>
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded-top" 
                             style="height: 200px; font-size: 1.2rem; font-weight: 500;">
                            No Image Available
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-success fw-bold mb-1">{{ $product->name }}</h5>
                        <p class="text-muted small mb-2">{{ $product->category->name ?? 'Uncategorized' }}</p>

                        {{-- Cost Details --}}
                        <ul class="list-unstyled small mb-2">
                            <li><strong>Material:</strong> KES {{ number_format($product->material_cost ?? 0, 2) }}</li>
                            <li><strong>Labour:</strong> KES {{ number_format($product->labour_cost ?? 0, 2) }}</li>
                            <li><strong>Total:</strong> <span class="text-success fw-bold">KES {{ number_format($product->total_cost ?? 0, 2) }}</span></li>
                        </ul>

                        <a href="{{ route('welding-products.show', $product->id) }}" 
                           class="btn btn-success btn-sm mt-auto align-self-start rounded-pill px-4">
                            View Details
                        </a>
                    </div>
                </div>
            </div>

            {{-- Image Modal --}}
            @if($product->image)
            <div class="modal fade" id="imageModal{{ $product->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $product->id }}" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-transparent border-0 shadow-none">
                  <div class="modal-body p-0 position-relative">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                         class="img-fluid rounded" style="max-height: 1000px; width: 100%; height: auto;">
                  </div>
                </div>
              </div>
            </div>
            @endif
        @empty
            <div class="col-12">
                <p class="text-center text-muted fs-5">No welding products found.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-5">
        {{ $products->links() }}
    </div>
</div>

<style>
    .product-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        transform: translateY(-4px);
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    .product-card img:hover {
        transform: scale(1.05);
    }

    .btn-outline-success.active,
    .btn-outline-success.active:hover,
    .btn-outline-success.active:focus {
        background-color: #198754;
        color: #fff;
        border-color: #198754;
        font-weight: 600;
        box-shadow: 0 4px 10px rgb(25 135 84 / 0.5);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
