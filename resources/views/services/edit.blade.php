@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="page-title">Edit Service</h1>
                <p class="text-muted">Update the details of the service</p>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('service.update', $service->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $service->name }}" required>
                            </div>


                               <div class="form-group">
                                        <label for="productDescription">Meta Description</label>
                                        <textarea id="meta_description" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror">{{ $service->meta_description }}
                                        </textarea>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="productDescription">Description</label>
                                        <textarea id="textarea" name="description" class="form-control @error('description') is-invalid @enderror">{{ $service->description }}
                                        </textarea>
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
    <label for="price">Price:</label>
    <input type="text" class="form-control" id="price" name="price" value="{{ $service->price ?? old('price') }}" placeholder="Enter price" required>
</div>


<div class="form-group">
    <label for="image_url">Image URL:</label>
    <input type="text" class="form-control" id="image_url" name="image_url" value="{{ $service->image_url ?? old('image_url') }}" placeholder="Enter image URL" required>
</div>






                            <button type="submit" class="btn btn-primary shadow-sm">Update</button>
                            <a href="{{ route('service.index') }}" class="btn btn-secondary shadow-sm">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
