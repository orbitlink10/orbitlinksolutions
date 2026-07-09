@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="page-title">Add Service</h1>
                <p class="text-muted">Fill in the details to add a new service</p>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('service.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
         <div class="form-group">
                                        <label for="productDescription">Meta Description</label>
                                        <textarea id="meta_description" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror"></textarea>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="productDescription">Description</label>
                                        <textarea id="textarea" name="description" class="form-control @error('description') is-invalid @enderror"></textarea>
                                        @error('description')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Tinymce Init Script -->
                                    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
                                    <script type="text/javascript">
                                        tinymce.init({
                                            selector: "textarea#textarea",
                                            plugins: "image advcode link lists media table code wordcount fullscreen",
                                            toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image media | code fullscreen",
                                            menubar: "file edit view insert format tools table help",
                                            height: 400,
                                            image_title: true,
                                            automatic_uploads: true,
                                            promotion: false,
                                            branding: false,
                                            file_picker_types: 'image',
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
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" name="price" class="form-control" step="0.01" required>
                            </div>
                            <button class="btn btn-primary">Save</button>
                            <a href="{{ route('service.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
