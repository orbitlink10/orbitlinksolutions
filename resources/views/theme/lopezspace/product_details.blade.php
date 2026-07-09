@extends('theme.lopezspace.layouts.main')
@section('title', $product->name)
@section('meta_description', $product->meta_description)

@push('meta')
<!-- Canonical URL -->
<link rel="canonical" href="{{ url()->current() }}" />

<!-- Meta Description -->
<meta name="description" content="{{ $product->meta_description }}" />

<!-- Open Graph Meta Tags -->
<meta property="og:title" content="{{ $product->meta_title }}" />
<meta property="og:description" content="{{ $product->meta_description }}" />
<meta property="og:image" content="{{ $product->photo ? url('/') . '/storage/' . $product->photo : asset('default-image.jpg') }}" />
<meta property="og:image:width" content="1478" />
<meta property="og:image:height" content="1108" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="{{ get_option('site_name') }}" />
<meta property="og:type" content="website" />

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="{{ url('/') }}" />
<meta name="twitter:title" content="{{ $product->meta_title }}" />
<meta name="twitter:description" content="{{ $product->meta_description }}" />
<meta name="twitter:image" content="{{ $product->photo ? url('/') . '/storage/' . $product->photo : asset('default-image.jpg') }}" />
@endpush

@section('main')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ url('/') }}" rel="nofollow">Home</a>
            <span></span>
            <a href="{{ route('view_product_category', ['slug' => App\Models\Category::find($product->category_id)->slug]) }}">
                      {{ App\Models\Category::find($product->category_id)->name }}
            </a>
            <span></span> {{ $product->name }}
        </div>
    </div>
</div>

<section class="mt-5 mb-5">
    <div class="container">
        <div class="row">

            <!-- Product Image Section -->
            <div class="col-lg-6">
                <div class="detail-gallery">
                    <!-- Carousel Section with Auto Slide and Fixed Height -->
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                        <div class="carousel-inner">
                            @if($mediafiles->count() > 0)
                                @foreach($mediafiles as $index => $media)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ $media->file_path }}" alt="{{ $product->name }}" class="d-block w-100" style="height: 600px; object-fit: cover; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="openModal('{{ $media->file_path }}', '{{ $index }}')">
                                    </div>
                                @endforeach
                            @else
                                <div class="carousel-item active">
                                    <img src="{{ url('/') }}/storage/{{ $product->photo }}" alt="{{ $product->name }}" class="d-block w-100" style="height: 600px; object-fit: cover; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="openModal('{{ url('/') }}/storage/{{ $product->photo }}', '0')">
                                </div>
                            @endif
                        </div>
                        <!-- Carousel Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal for Image Popup with Slider -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <!-- Carousel inside Modal -->
                            <div id="modalCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner" id="modalCarouselInner">
                                    @if($mediafiles->count() > 0)
                                        @foreach($mediafiles as $index => $media)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <img src="{{ $media->file_path }}" class="d-block w-100" style="height: 500px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="carousel-item active">
                                            <img src="{{ url('/') }}/storage/{{ $product->photo }}" class="d-block w-100" style="height: 500px; object-fit: cover;">
                                        </div>
                                    @endif
                                </div>
                                <!-- Carousel Controls -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#modalCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function openModal(imageUrl, index) {
                    // Set image URL to modal
                    const modalCarouselInner = document.getElementById('modalCarouselInner');
                    const items = modalCarouselInner.getElementsByClassName('carousel-item');
                    
                    // Remove active class from all carousel items
                    for (let i = 0; i < items.length; i++) {
                        items[i].classList.remove('active');
                    }

                    // Add active class to clicked item
                    items[index].classList.add('active');
                    
                    // Open the modal
                    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
                    modal.show();
                }
            </script>

            <!-- Product Details Section -->
            <div class="col-lg-6">
                <div class="detail-info">
                    <h2 class="title-detail fs-4 fw-bold text-dark">{{ $product->name }}</h2>
                    <div class="product-price-cover mt-3">
                        <div class="product-price">
                            @if($product->has_price)
                                <div class="d-flex align-items-center">
                                    <ins><span class="text-brand fs-3">{{ number_format($product->price, 2) }}</span></ins>
                                    <ins><span class="old-price ms-3 text-decoration-line-through">{{ number_format($product->marked_price, 2) }}</span></ins>
                                      @if($product->marked_price)
                                    <span class="save-price ms-3 bg-light p-1 rounded-2 text-success">{{ discount($product->id) }}% Off</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="short-desc mt-3 mb-4">
                        <p class="text-muted">{!! Str::words(strip_tags($product->description), 40, '...') !!}</p>
                    </div>
                    <div class="bt-1 border-color-1 mt-3 mb-4"></div>


                  

                                           

                    <div class="detail-extralink">
                        <div class="product-extra-link2">
                            @if($product->quantity > 0)
                                @if($product->has_price)
<form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <div class="attr-detail attr-size">
        <strong class="mr-10">Size</strong>
        <ul class="list-filter size-filter font-small">
            @forelse($product->sizes as $size)
                <li>
                    <input type="radio" 
                           id="size-{{ $size->id }}" 
                           name="size_id" 
                           value="{{ $size->id }}" 
                           class="radio-custom"
                           {{ old('size', $product->sizes->first()->name) == $size->name ? 'checked' : '' }}>
                    <label for="size-{{ $size->id }}">{{ $size->name }}</label>
                </li>
            @empty
                <li>No sizes available.</li>
            @endforelse
        </ul>
    </div>

    <div class="bt-1 border-color-1 mt-3 mb-4">
        <h3></h3>
    </div>
    <button type="submit" class="btn btn-primary btn-lg shadow-lg me-3">Buy Now</button>
</form>



<style type="text/css">
    /* Hide the default radio button */
.radio-custom {
    display: none;
}

/* Style the label to look like your existing clickable items */
.radio-custom + label {
    padding: 5px 10px;
    border: 1px solid #ccc;
    cursor: pointer;
    margin-right: 5px;
    /* Add any additional styles to match your UI */
}

/* Highlight the selected size */
.radio-custom:checked + label {
    background-color: #f0f0f0;
    border-color: #333;
    /* Adjust the active state styling as needed */
}

</style>
                                @else
                                    <button type="button" class="btn btn-dark btn-lg shadow-lg" data-bs-toggle="modal" data-bs-target="#quoteModal">Get Quote</button>
                                @endif
                            @else
                                <button type="button" class="btn btn-dark btn-lg shadow-lg" data-bs-toggle="modal" data-bs-target="#notifyModal">Notify Me</button>
                            @endif
                        </div>
                    </div>

                    <ul class="product-meta font-xs text-muted mt-4">
                        @if($product->has_price)
                            <li class="d-flex justify-content-between align-items-center">
                                <span>Availability:</span>
                                <span class="in-stock text-success ms-2">{{ $product->quantity > 0 ? 'Available in store' : 'Out of stock' }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tab Section for Description -->
        <div class="tab-style3 mt-5">
            <ul class="nav nav-tabs text-uppercase">
                <li class="nav-item">
                    <a class="nav-link active" id="Description-tab" data-bs-toggle="tab" href="#Description">Description</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="Description">
                    <div class="container">
                        <div id="homepage-description">
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
@endsection

@section('scripts')
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
