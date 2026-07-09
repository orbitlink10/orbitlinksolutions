@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <div class="container mt-4">
            <h1>Add Sizes for {{ $product->name }}</h1>
            <p class="text-muted">
                Specify the sizes available for this product. Separate sizes with commas if adding multiple sizes.
            </p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form to add sizes -->
            <form action="{{ route('products.sizes.store', $product->id) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="sizes">Sizes</label>
                    <input type="text" name="name" id="name" class="form-control" 
                           placeholder="e.g., S, M, L, XL" value="{{ old('name') }}">
                    <small class="form-text text-muted">Enter size</small>
                </div>

                <button type="submit" class="btn btn-primary">Add Sizes</button>
            </form>

            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-secondary mt-3">
                Back to Edit Product
            </a>

            <!-- List of existing sizes -->
            <div class="mt-5">
                <h2>Existing Sizes</h2>
                @if($product->sizes->count())
                    <ul class="list-group">
                        @foreach($product->sizes as $size)
                            <li class="list-group-item">
                                {{ $size->name }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No sizes have been added yet.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
