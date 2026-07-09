@extends('layouts.appbar')

@section('title', 'Edit Welding Product')

@section('content')
<div class="container py-4 px-4 px-md-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="card shadow border-0">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0 fw-bold">Edit Welding Product</h4>
                </div>

                <div class="card-body px-4 px-md-5">
                    @include('flash_msg')

                    <form action="{{ route('admin.welding-products.update', $welding_product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">

                            {{-- Product Name --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="name" id="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', $welding_product->name) }}" placeholder="Product Name" required>
                                    <label for="name">Product Name <span class="text-danger">*</span></label>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Category --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="category_id" id="category_id"
                                            class="form-select @error('category_id') is-invalid @enderror" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @selected(old('category_id', $welding_product->category_id) == $category->id)>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="category_id">Category <span class="text-danger">*</span></label>
                                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Image --}}
                            <div class="col-12">
                                <label for="image" class="form-label">Product Image <small class="text-muted">(optional)</small></label>
                                <input type="file" name="image" id="image"
                                       class="form-control @error('image') is-invalid @enderror"
                                       accept="image/*">
                                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror

                                @if($welding_product->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $welding_product->image) }}" alt="Current Image"
                                             class="img-thumbnail" style="max-height: 200px;">
                                    </div>
                                @endif
                            </div>

                            {{-- Material Cost --}}
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" step="0.01" name="material_cost" id="material_cost"
                                           class="form-control @error('material_cost') is-invalid @enderror"
                                           placeholder="Material Cost"
                                           value="{{ old('material_cost', $welding_product->material_cost) }}">
                                    <label for="material_cost">Material Cost (KES)</label>
                                    @error('material_cost') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Labour Cost --}}
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" step="0.01" name="labour_cost" id="labour_cost"
                                           class="form-control @error('labour_cost') is-invalid @enderror"
                                           placeholder="Labour Cost"
                                           value="{{ old('labour_cost', $welding_product->labour_cost) }}">
                                    <label for="labour_cost">Labour Cost (KES)</label>
                                    @error('labour_cost') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Total Cost --}}
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" step="0.01" name="total_cost" id="total_cost"
                                           class="form-control @error('total_cost') is-invalid @enderror"
                                           placeholder="Total Cost"
                                           value="{{ old('total_cost', $welding_product->total_cost) }}" readonly>
                                    <label for="total_cost">Total Cost (KES)</label>
                                    @error('total_cost') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Buttons --}}
                            <div class="col-12 d-flex justify-content-between mt-4">
                                <a href="{{ route('admin.welding-products.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-warning px-4">
                                    <i class="bi bi-pencil-square"></i> Update Product
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- Auto-calculate total_cost --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const materialInput = document.getElementById('material_cost');
        const labourInput = document.getElementById('labour_cost');
        const totalInput = document.getElementById('total_cost');

        function calculateTotal() {
            const material = parseFloat(materialInput.value) || 0;
            const labour = parseFloat(labourInput.value) || 0;
            totalInput.value = (material + labour).toFixed(2);
        }

        materialInput.addEventListener('input', calculateTotal);
        labourInput.addEventListener('input', calculateTotal);
    });
</script>
@endsection
