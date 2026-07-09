@extends('layouts.appbar')

@section('content')
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center mb-3">
                    <div class="col-sm-6">
                        <h1 class="page-title">Add Product</h1>
                        <p class="text-muted">Fill in the product details below to add a new item</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Product Form Card -->
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                @if(is_array($errors) ? count($errors) > 0 : $errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @if(is_array($errors))
                                                @foreach ($errors as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            @else
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Product Name -->
                                    <div class="form-group">
                                        <label for="productName">Product Name</label>
                                        <input type="text" class="form-control {{ (is_array($errors) && isset($errors['name'])) || (!is_array($errors) && $errors->has('name')) ? 'is-invalid' : '' }}" 
                                               name="name" value="{{ old('name') }}" id="productName" 
                                               placeholder="Enter product name">
                                        @if(!is_array($errors))
                                            @error('name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        @elseif(isset($errors['name']))
                                            <span class="invalid-feedback">{{ $errors['name'] }}</span>
                                        @endif
                                    </div>

                                    <!-- Price -->
                                    <div class="form-group">
                                        <label for="productPrice">Price (KES)</label>
                                        <input type="number" class="form-control {{ (is_array($errors) && isset($errors['price'])) || (!is_array($errors) && $errors->has('price')) ? 'is-invalid' : '' }}"
                                               name="price" value="{{ old('price') }}" id="productPrice" 
                                               placeholder="Enter product price">
                                        @if(!is_array($errors))
                                            @error('price')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        @elseif(isset($errors['price']))
                                            <span class="invalid-feedback">{{ $errors['price'] }}</span>
                                        @endif
                                    </div>

                                    <!-- Marked Price -->
                                    <div class="form-group">
                                        <label for="markedPrice">Marked Price (KES)</label>
                                        <input type="number" class="form-control {{ (is_array($errors) && isset($errors['marked_price'])) || (!is_array($errors) && $errors->has('marked_price')) ? 'is-invalid' : '' }}"
                                               name="marked_price" value="{{ old('marked_price') }}" id="markedPrice" 
                                               placeholder="Enter marked price">
                                        @if(!is_array($errors))
                                            @error('marked_price')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        @elseif(isset($errors['marked_price']))
                                            <span class="invalid-feedback">{{ $errors['marked_price'] }}</span>
                                        @endif
                                    </div>

                                    <!-- Quantity -->
                                    <div class="form-group">
                                        <label for="productQuantity">Quantity</label>
                                        <input type="number" class="form-control {{ (is_array($errors) && isset($errors['quantity'])) || (!is_array($errors) && $errors->has('quantity')) ? 'is-invalid' : '' }}"
                                               name="quantity" value="{{ old('quantity') }}" id="productQuantity"
                                               placeholder="Enter product quantity">
                                        @if(!is_array($errors))
                                            @error('quantity')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        @elseif(isset($errors['quantity']))
                                            <span class="invalid-feedback">{{ $errors['quantity'] }}</span>
                                        @endif
                                    </div>

                                    <!-- Category -->
                                    <div class="form-group">
                                        <label for="productCategory">Category</label>
                                        <select class="form-control select2 {{ (is_array($errors) && isset($errors['category_id'])) || (!is_array($errors) && $errors->has('category_id')) ? 'is-invalid' : '' }}"
                                                name="category_id" id="productCategory" style="width: 100%;">
                                            <option value="" selected>Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if(!is_array($errors))
                                            @error('category_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        @elseif(isset($errors['category_id']))
                                            <span class="invalid-feedback">{{ $errors['category_id'] }}</span>
                                        @endif
                                    </div>

                                    <!-- Subcategory -->
                                    <div class="form-group">
                                        <label for="productSubCategory">Subcategory</label>
                                        <select class="form-control select2 {{ (is_array($errors) && isset($errors['sub_category_id'])) || (!is_array($errors) && $errors->has('sub_category_id')) ? 'is-invalid' : '' }}"
                                                name="sub_category_id" id="productSubCategory" style="width: 100%;">
                                            <option value="" selected>Select Subcategory</option>
                                        </select>
                                        @if(!is_array($errors))
                                            @error('sub_category_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        @elseif(isset($errors['sub_category_id']))
                                            <span class="invalid-feedback">{{ $errors['sub_category_id'] }}</span>
                                        @endif
                                    </div>

                                    <!-- Include jQuery -->
                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                    <script>
                                        $(document).ready(function() {
                                            $('#productCategory').change(function() {
                                                var categoryId = $(this).val();
                                                console.log(categoryId);
                                                if (categoryId) {
                                                    $.ajax({
                                                        url: '/get-subcategories/' + categoryId,
                                                        type: 'GET',
                                                        success: function(data) {
                                                            console.log(data);
                                                            $('#productSubCategory').empty();
                                                            $('#productSubCategory').append('<option value="" selected>Select Subcategory</option>');
                                                            if (data.subcategories && Object.keys(data.subcategories).length > 0) {
                                                                $.each(data.subcategories, function(id, name) {
                                                                    $('#productSubCategory').append('<option value="'+ id +'">'+ name +'</option>');
                                                                });
                                                            } else {
                                                                console.log('No subcategories found');
                                                                $('#productSubCategory').append('<option value="" disabled>No subcategories available</option>');
                                                            }
                                                        },
                                                        error: function(xhr, status, error) {
                                                            console.error('AJAX Error: ' + status + ', ' + error);
                                                        }
                                                    });
                                                } else {
                                                    $('#productSubCategory').empty();
                                                    $('#productSubCategory').append('<option value="" selected>Select Subcategory</option>');
                                                }
                                            });
                                        });
                                    </script>

                                    <!-- Meta Description -->
                                    <div class="form-group">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea name="meta_description" id="meta_description" class="form-control" rows="3">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="productDescription">Description</label>
                                        <textarea id="textarea" name="description" class="form-control {{ (is_array($errors) && isset($errors['description'])) || (!is_array($errors) && $errors->has('description')) ? 'is-invalid' : '' }}">
                                            {{ old('description') }}
                                        </textarea>
                                        @if(!is_array($errors))
                                            @error('description')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        @elseif(isset($errors['description']))
                                            <span class="invalid-feedback">{{ $errors['description'] }}</span>
                                        @endif
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

                                    <!-- Image Upload -->
                                    <div class="form-group">
                                        <label for="productImage">Product Image (optional)</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input {{ (is_array($errors) && isset($errors['photo'])) || (!is_array($errors) && $errors->has('photo')) ? 'is-invalid' : '' }}"
                                                   id="productImage" name="photo" onchange="updateFileLabel(this)">
                                            <label class="custom-file-label" for="productImage">Choose file</label>
                                        </div>
                                        @if(!is_array($errors))
                                            @error('photo')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        @elseif(isset($errors['photo']))
                                            <span class="invalid-feedback">{{ $errors['photo'] }}</span>
                                        @endif
                                    </div>

                                    <!-- Form Actions -->
                                    <div class="form-footer text-right">
                                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function updateFileLabel(input) {
            let fileName = input.files[0].name;
            input.nextElementSibling.innerText = fileName;
        }
    </script>
@endsection
