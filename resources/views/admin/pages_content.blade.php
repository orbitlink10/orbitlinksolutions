@extends('layouts.appbar')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Homepage Content</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Update Content</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Homepage Content Management</h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('save_settings') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Hero Header Title -->
                                <div class="form-group">
                                    <label for="hero_header_title">Hero Header Title</label>
                                    <input type="text" class="form-control" name="hero_header_title" value="{{ get_option('hero_header_title', 'Pepasa Stationers') }}" id="hero_header_title" placeholder="Hero header title" required>
                                    @if ($errors->has('hero_header_title'))
                                        <span class="text-danger">{{ $errors->first('hero_header_title') }}</span>
                                    @endif
                                </div>

                                <!-- Hero Header Description -->
                                <div class="form-group">
                                    <label for="hero_header_description">Hero Header Description</label>
                                    <textarea class="form-control" name="hero_header_description" id="hero_header_description" required>{{ get_option('hero_header_description', 'Your one-stop shop for all stationery supplies. From office essentials to school supplies, we\'ve got everything you need to stay organized and productive.') }}</textarea>
                                    @if ($errors->has('hero_header_description'))
                                        <span class="text-danger">{{ $errors->first('hero_header_description') }}</span>
                                    @endif
                                </div>


                                                                <div class="form-group">
                                    <label for="hero_header_title">Hero Image (1280 x 720)</label>
                                    <input type="file" class="form-control" name="hero_image" id="hero_header_title" placeholder="Hero header title" >


     <img src="{{ get_option('hero_image', 'Pepasa Stationers') }}">
                              
                                </div>


                                <!-- Why Choose Title -->
                                <div class="form-group">
                                    <label for="why_choose_title">Why Choose Title</label>
                                    <input type="text" class="form-control" name="why_choose_title" value="{{ get_option('why_choose_title', 'Why Choose Pepasa Stationers?') }}" id="why_choose_title" required>
                                    @if ($errors->has('why_choose_title'))
                                        <span class="text-danger">{{ $errors->first('why_choose_title') }}</span>
                                    @endif
                                </div>

                                <!-- Why Choose Description -->
                                <div class="form-group">
                                    <label for="why_choose_description">Why Choose Description</label>
                                    <textarea class="form-control" name="why_choose_description" id="why_choose_description" required>{{ get_option('why_choose_description', 'At Pepasa Stationers, we offer a wide range of high-quality stationery products for individuals, businesses, and educational institutions.') }}</textarea>
                                    @if ($errors->has('why_choose_description'))
                                        <span class="text-danger">{{ $errors->first('why_choose_description') }}</span>
                                    @endif
                                </div>


                                <!-- Products Section Title -->
                                <div class="form-group">
                                    <label for="products_section_title">Products Section Title</label>
                                    <input type="text" class="form-control" name="products_section_title" value="{{ get_option('products_section_title', 'Our Stationery Collection') }}" id="products_section_title" required>
                                    @if ($errors->has('products_section_title'))
                                        <span class="text-danger">{{ $errors->first('products_section_title') }}</span>
                                    @endif
                                </div>

<!-- Home Page Description -->
<div class="form-group">
    <label for="home_page_description">Home Page Content</label>
    <textarea id="home_page_description" name="homepage_description">{{ get_option('homepage_description') }}</textarea>
</div>

<!-- About Us -->
<div class="form-group">
    <label for="about">About Us</label>
    <textarea id="about" name="about">{{ get_option('about') }}</textarea>
</div>

<!-- FAQ -->
<div class="form-group">
    <label for="faq">FAQ</label>
    <textarea id="faq" name="faq">{{ get_option('faq') }}</textarea>
</div>


<!-- FAQ -->
<div class="form-group">
    <label for="terms">Terms</label>
    <textarea id="terms" name="terms">{{ get_option('terms') }}</textarea>
</div>

<!-- Include TinyMCE -->
<script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
    // Initialize TinyMCE for Home Page Content
    tinymce.init({
        selector: "textarea#home_page_description",
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

    // Initialize TinyMCE for About Us
    tinymce.init({
        selector: "textarea#about",
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

    // Initialize TinyMCE for FAQ
    tinymce.init({
        selector: "textarea#faq",
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



        // Initialize TinyMCE for FAQ
    tinymce.init({
        selector: "textarea#terms",
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

<!-- Shared Styles -->
<style>
    textarea {
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 10px;
        font-size: 14px;
        width: 100%;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    }
</style>



                                <!-- Submit button -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
