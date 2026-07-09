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

    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm border-0">
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

        <!-- TinyMCE from CDN -->
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
                promotion: false,  // remove the "Powered by TinyMCE" link
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
