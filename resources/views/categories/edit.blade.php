<!-- resources/views/categories/edit.blade.php -->

@extends('layouts.appbar') 
{{-- Ensure this layout includes Bootstrap 5 CSS/JS --}}

@section('content')
<div class="content-wrapper">
    <div class="container py-4">

        {{-- Optionally include a flash message partial --}}
        @include('flash_msg')

        <h3 class="mb-4">Edit Category</h3>

        {{-- Display validation errors if any --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('categories.update', $category->id) }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      data-tinymce-upload-form>
                    @csrf
                    @method('PUT') {{-- Updating uses PUT/PATCH --}}

                    {{-- Category Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            value="{{ old('name', $category->name) }}" 
                            required
                        >
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Meta Description --}}
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea 
                            class="form-control @error('meta_description') is-invalid @enderror"
                            name="meta_description"
                            id="meta_description"
                            rows="3"
                        >{{ old('meta_description', $category->meta_description) }}</textarea>
                        @error('meta_description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Description with TinyMCE --}}
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <textarea 
                            name="description"
                            id="description"
                            rows="5"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Enter category description"
                        >{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    @include('categories.partials.tinymce-description')

                    {{-- Current Photo (if exists) --}}
                    @if($category->photo)
                        <div class="mb-3">
                            <label class="form-label">Current Photo</label><br>
                            <img 
                                src="{{ uploaded_image_url($category->photo) }}"
                                alt="{{ $category->name }}" 
                                class="img-thumbnail" 
                                style="max-width: 150px;"
                            >
                        </div>
                    @endif

                    {{-- Upload New Photo --}}
                    <div class="mb-3">
                        <label for="photo" class="form-label">Change Photo (optional)</label>
                        <input 
                            type="file"
                            class="form-control @error('photo') is-invalid @enderror"
                            id="photo"
                            name="photo"
                        >
                        @error('photo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="text-end">
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary me-2">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Update Category
                        </button>
                    </div>
                </form>
            </div> <!-- /card-body -->
        </div> <!-- /card -->

    </div> <!-- /container -->
</div> <!-- /content-wrapper -->
@endsection
