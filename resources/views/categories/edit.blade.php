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
                      enctype="multipart/form-data">
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

                    {{-- TinyMCE (CDN) --}}
                    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.4.2/tinymce.min.js"></script>
                    <script>
                        tinymce.init({
                            selector: '#description',
                            plugins: 'image link lists media table code wordcount fullscreen',
                            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image media | code fullscreen',
                            menubar: 'file edit view insert format tools table help',
                            height: 500,
                            branding: false,
                            file_picker_types: 'image',
                            automatic_uploads: true,
                            image_title: true,
                            promotion: false,  // Remove the "Powered by TinyMCE" link
                            file_picker_callback: function (cb, value, meta) {
                                let input = document.createElement('input');
                                input.setAttribute('type', 'file');
                                input.setAttribute('accept', 'image/*');
                                input.onchange = function () {
                                    let file = this.files[0];
                                    let reader = new FileReader();
                                    reader.onload = function () {
                                        let id = 'blobid' + (new Date()).getTime();
                                        let blobCache = tinymce.activeEditor.editorUpload.blobCache;
                                        let base64 = reader.result.split(',')[1];
                                        let blobInfo = blobCache.create(id, file, base64);
                                        blobCache.add(blobInfo);
                                        cb(blobInfo.blobUri(), { title: file.name });
                                    };
                                    reader.readAsDataURL(file);
                                };
                                input.click();
                            },
                        });
                    </script>

                    {{-- Current Photo (if exists) --}}
                    @if($category->photo)
                        <div class="mb-3">
                            <label class="form-label">Current Photo</label><br>
                            <img 
                                src="{{ $category->photo }}" 
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
