@extends('theme.starlinknew.layouts.main')
@section('title', $product->name)
@section('meta_description', $product->meta_description)

@section('og_title', $product->meta_title ?: $product->name)
@section('og_description', $product->meta_description)
@section('og_image', $product->photo ? url('/') . '/storage/' . $product->photo : get_option('hero_image'))
@section('og_url', url()->current())
@section('og_type', 'product')

@section('twitter_title', $product->meta_title ?: $product->name)
@section('twitter_description', $product->meta_description)
@section('twitter_image', $product->photo ? url('/') . '/storage/' . $product->photo : get_option('hero_image'))

@push('meta')
@php
    $category = App\Models\Category::find($product->category_id);
    $elements = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => url('/'),
        ],
    ];
    if ($category) {
        $elements[] = [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => $category->name,
            'item' => route('view_product_category', ['slug' => $category->slug]),
        ];
        $finalPos = 3;
    } else {
        $finalPos = 2;
    }
    $elements[] = [
        '@type' => 'ListItem',
        'position' => $finalPos,
        'name' => $product->name,
        'item' => url()->current(),
    ];
    $breadcrumb = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $elements,
    ];
@endphp
<script type="application/ld+json">@json($breadcrumb, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)</script>
@endpush

@push('meta')
@php
    $images = [];
    if (isset($mediafiles) && $mediafiles->count() > 0) {
        foreach ($mediafiles as $m) {
            $images[] = asset($m->file_path);
        }
    } else {
        if (!empty($product->photo)) {
            $images[] = url('/') . '/storage/' . $product->photo;
        } elseif (get_option('hero_image')) {
            $images[] = get_option('hero_image');
        }
    }

    $brandName = \Illuminate\Support\Str::contains(\Illuminate\Support\Str::lower($product->name ?? ''), 'starlink')
        ? 'Starlink'
        : (get_option('site_name') ?: null);

    $productSchema = [
        '@context'   => 'https://schema.org',
        '@type'      => 'Product',
        '@id'        => url()->current() . '#product',
        'name'       => $product->name,
        'description'=> strip_tags($product->meta_description ?: $product->name),
        'image'      => $images,
        'url'        => url()->current(),
    ];

    if ($category ?? false) {
        $productSchema['category'] = $category->name;
    }
    if ($brandName) {
        $productSchema['brand'] = [ '@type' => 'Brand', 'name' => $brandName ];
    }
    if (!empty($product->has_price) && !empty($product->price)) {
        $productSchema['offers'] = [
            '@type'         => 'Offer',
            'priceCurrency' => 'KES',
            'price'         => number_format($product->price, 2, '.', ''),
            'url'           => url()->current(),
            'availability'  => 'https://schema.org/InStock',
            'itemCondition' => 'https://schema.org/NewCondition',
        ];
    }
@endphp
<script type="application/ld+json">@json($productSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)</script>
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
                    <h1 class="title-detail fs-4 fw-bold text-dark">{{ $product->name }}</h1>
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
                                        <button type="submit" class="btn btn-primary btn-lg shadow-lg me-3">Add to cart</button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-dark btn-lg shadow-lg" data-bs-toggle="modal" data-bs-target="#quoteModal">Get Quote</button>
                                @endif
                            @else
                                <button type="button" class="btn btn-dark btn-lg shadow-lg" data-bs-toggle="modal" data-bs-target="#notifyModal">Notify Me</button>
                            @endif

                                        @include('theme.lucare.modals.notify')
                                        @include('theme.lucare.modals.quote')
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
