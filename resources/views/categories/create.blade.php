@extends('layouts.appbar')

@section('content')
<div class="content-wrapper">
<div class="container py-4">
    <h1 class="mb-4">Create Category</h1>

    {{-- Display validation errors, if any --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm border-0" data-tinymce-upload-form>
        @csrf

        <!-- Category Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-control @error('name') is-invalid @enderror" 
                value="{{ old('name') }}" 
                placeholder="Enter category name" 
                required
            >
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- UPF Grade Field -->
        <div class="mb-3">
            <label for="upfGrade" class="form-label">Meta description</label>
       <textarea class="form-control" name="meta_description"></textarea>
            @error('upf_grade')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Description with TinyMCE -->
        <div class="mb-3">
            <label for="description" class="form-label">Description (Optional)</label>
            <textarea 
                name="description" 
                id="description" 
                rows="5"
                class="form-control @error('description') is-invalid @enderror"
                placeholder="Enter category description"
            >{{ old('description') }}</textarea>
            @error('description')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        @include('categories.partials.tinymce-description')

        <!-- Photo Upload (Optional) -->
        <div class="mb-3">
            <label for="photo" class="form-label">Photo (Optional)</label>
            <input 
                type="file"
                name="photo" 
                id="photo"
                class="form-control @error('photo') is-invalid @enderror"
            >
            @error('photo')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Form Actions -->
        <div class="text-end">
            <a href="{{ route('categories.index') }}" class="btn btn-secondary me-2">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                Create Category
            </button>
        </div>
    </form>
</div></div>
@endsection
