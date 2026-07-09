@extends('layouts.appbar')

@section('content')
   <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <h1 class="font-weight-bold">Manage Pages</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <!-- You can add a breadcrumb or action button here -->
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title font-weight-bold">Add New Post</h3>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            <form action="{{ route('save-page') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Meta Title -->
                                <div class="form-group">
                                    <label for="meta_title">Meta Title</label>
                                    <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title') }}" id="meta_title" placeholder="Enter Meta Title">
                                </div>

                                <!-- Meta Description -->
                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <input type="text" class="form-control" name="meta_description" value="{{ old('meta_description') }}" id="meta_description" placeholder="Enter Meta Description">
                                </div>

                                <!-- Keyword Title -->
                                <div class="form-group">
                                    <label for="title">Page Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}" id="title" placeholder="Enter Keyword Title">
                                </div>

                                <!-- Image Alt Text -->
                                <div class="form-group">
                                    <label for="alter_text">Image Alt Text</label>
                                    <input type="text" class="form-control" name="alter_text" value="{{ old('alter_text') }}" id="alter_text" placeholder="Enter Image Alt Text">
                                </div>

                                <!-- Heading 2 -->
                                <div class="form-group">
                                    <label for="head_2">Heading 2</label>
                                    <input type="text" class="form-control" name="head_2" value="{{ old('head_2') }}" id="head_2" placeholder="Enter Heading 2">
                                </div>

                                <!-- Type Select -->
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select class="form-control select2" name="type" id="type" style="width: 100%;">
                                       
                                        <option selected value="Post">Post</option>
                                        <option value="Page">Page</option>
                                    </select>
                                </div>

                       



                                <!-- Row for Page Description -->
                        <div class="form-group">
                                    <label>Page Description:</label>
                                   
                                        <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
                                        <textarea id="textarea" name="description"></textarea>
                                    </div>

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
                                                setup: function (editor) {
                                                    editor.on('ExecCommand', function (e) {
                                                        if (e.command === 'mceUpdateImage') {
                                                            const img = editor.selection.getNode();
                                                            img.setAttribute('data-src', img.src);
                                                        }
                                                    });
                                                },
                                            });
                                        </script>     

                                        <style>
                                            textarea#textarea {
                                                border-radius: 8px;
                                                border: 1px solid #ccc;
                                                padding: 10px;
                                                font-size: 14px;
                                                width: 100%;
                                                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
                                            }
                                        </style>
                                 
                             


                                <!-- File Upload -->
                                <div class="form-group">
                                    <label for="exampleInputFile">Upload Image (optional, only for Posts)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="photo">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>

                                <!-- Form Buttons -->
                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>


                                   
@endsection
