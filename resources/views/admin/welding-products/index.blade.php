@extends('layouts.appbar')

@section('title', 'Welding Products')

@section('content')
<div class="container py-4 px-4 px-md-5">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-success fw-bold mb-0">Welding Products</h1>
        <a href="{{ route('admin.welding-products.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Add New Product
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Products Table --}}
    @if($products->count())
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-nowrap">
            <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Image</th>
                    <th scope="col">Material (KES)</th>
                    <th scope="col">Labour (KES)</th>
                    <th scope="col">Total (KES)</th>
                    <th scope="col" class="text-center" style="width: 160px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $index => $product)
                <tr>
                    <td>{{ $products->firstItem() + $index }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                    <td>
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                 class="img-thumbnail rounded" style="max-height: 70px; width: auto;">
                        @else
                            <span class="text-muted fst-italic">No Image</span>
                        @endif
                    </td>
                    <td>{{ number_format($product->material_cost ?? 0, 2) }}</td>
                    <td>{{ number_format($product->labour_cost ?? 0, 2) }}</td>
                    <td class="fw-semibold text-success">{{ number_format($product->total_cost ?? 0, 2) }}</td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('admin.welding-products.edit', $product->id) }}"
                               class="btn btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.welding-products.destroy', $product->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger" type="submit" title="Delete">
                                    <i class="bi bi-trash3"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $products->links() }}
    </div>

    @else
        <div class="alert alert-info text-center">
            No welding products found.
        </div>
    @endif
</div>
@endsection
