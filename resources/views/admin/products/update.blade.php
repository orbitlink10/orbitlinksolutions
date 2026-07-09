@extends('layouts.appbar')

@section('content')

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center mb-3">
                    <div class="col-sm-6">
                        <h1 class="page-title">Edit Product</h1>
                        <p class="text-muted">Update the product details below</p>

                        <a href="{{ route('products.sizes.create', $product->id) }}" class="btn btn-primary">
                            Add Sizes for {{ $product->name }}
                        </a>
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
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <!-- Product Name -->
                                    <div class="form-group">
                                        <label for="productName">Product Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               name="name" value="{{ $product->name }}" id="productName" 
                                               placeholder="Enter Product Name">
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Price (initial input, used for non-has_price case) -->
                                    <div class="form-group">
                                        <label for="productPrice">Price (KES)</label>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                               name="price" value="{{ $product->price }}" id="productPrice">
                                        @error('price')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Marked Price -->
                                    <div class="form-group">
                                        <label for="marked_price">Marked Price (KES)</label>
                                        <input type="number" class="form-control @error('marked_price') is-invalid @enderror" name="marked_price" value="{{ $product->marked_price }}" id="marked_price">
                                        @error('marked_price')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Has Price Toggle -->
                                    <div class="form-group">
                                        <label for="hasPriceToggle">Has Price</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="hasPriceToggle" 
                                                   name="has_price" 
                                                   value="1" 
                                                   {{ $product->has_price ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hasPriceToggle">
                                                {{ $product->has_price ? 'Yes' : 'No' }}
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Price Input Container -->
                                    <div class="form-group mt-3" id="priceInputContainer" {{ !$product->has_price ? 'style=display:none;' : '' }}>
                                        <label for="productPrice">Price (KES)</label>
                                        <input type="number" 
                                               class="form-control @error('price') is-invalid @enderror" 
                                               name="price" 
                                               value="{{ $product->price }}" 
                                               id="productPrice">
                                        @error('price')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Quantity -->
                                    <div class="form-group">
                                        <label for="productQuantity">Quantity</label>
                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                               name="quantity" value="{{ $product->quantity }}" id="productQuantity">
                                        @error('quantity')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Category -->
                                    <div class="form-group">
                                        <label for="productCategory">Category</label>
                                        <select class="form-control select2 @error('category_id') is-invalid @enderror" 
                                                name="category_id" id="productCategory" style="width: 100%;">
                                            <option value="{{ $product->category_id }}" selected>{{ category($product->category_id)->name ?? 'N/A' }}</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Subcategory -->
                                    <div class="form-group">
                                        <label for="productSubCategory">Subcategory</label>
                                        <select class="form-control select2 @error('sub_category_id') is-invalid @enderror" 
                                                name="sub_category_id" id="productSubCategory" style="width: 100%;">
                                            <option value="{{ $product->sub_category_id }}" selected>{{ sub_category($product->sub_category_id)->name ?? 'N/A' }}</option>
                                            @foreach($sub_categories as $sub_cat)
                                                <option value="{{ $sub_cat->id }}">{{ $sub_cat->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('sub_category_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Google Merchant Upload Field -->
                                    <div class="form-group">
                                        <label for="googleMerchantToggle">Upload to Google Merchant</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="googleMerchantToggle" 
                                                   name="google_merchant" 
                                                   value="1" 
                                                   {{ $product->google_merchant ? 'checked' : '' }}>
                                            <label class="form-check-label" for="googleMerchantToggle">
                                                {{ $product->google_merchant ? 'Yes' : 'No' }}
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Meta Description -->
                                    <div class="form-group">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea name="meta_description" id="meta_description" class="form-control" rows="3">{{ old('meta_description', $product->meta_description) }}</textarea>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="productDescription">Description</label>
                                        <textarea id="textarea" name="description" class="form-control @error('description') is-invalid @enderror">{{ $product->description }}</textarea>
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

                                    <!-- Image Upload -->
                                    <div class="form-group">
                                        <label for="productImage">Featured Image</label>
                                        <div class="mb-2">
                                            <img src="/images?path={{ $product->photo }}" alt="Current Product Image" width="100" height="100">
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('photo') is-invalid @enderror" 
                                                   id="productImage" name="photo" onchange="updateFileLabel(this)">
                                            <label class="custom-file-label" for="productImage">Choose file</label>
                                        </div>
                                        @error('photo')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Form Actions -->
                                    <div class="form-footer text-right">
                                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h1>Upload Media for product: {{ $product->name }}</h1>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('products.media') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div class="form-group mb-3">
                                        <label for="files">Choose Files</label>
                                        <input type="file" name="files[]" id="files" class="form-control" multiple required>
                                        <small class="form-text text-muted">You can select multiple files to upload.</small>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="captions">Captions (optional)</label>
                                        <textarea name="captions" id="captions" rows="3" class="form-control" placeholder="Provide captions separated by commas (e.g., Caption1, Caption2)"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </form>
                            </div>
                        </div>

                        @include('admin.products.media')
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Script to update file input label -->
    <script>
        function updateFileLabel(input) {
            let fileName = input.files[0].name;
            input.nextElementSibling.innerText = fileName;
        }
    </script>
@endsection
