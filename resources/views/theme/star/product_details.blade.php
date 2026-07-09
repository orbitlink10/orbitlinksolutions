@extends('theme.star.layouts.main')
@section('title', $product->name)
@section('meta_description', $product->meta_description)

@section('social-meta')
<!-- Canonical URL -->
<link rel="canonical" href="{{ url()->current() }}" />
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

<meta property="product:sale_price:currency" content="KES">
<meta property="product:price:amount" content="{{ number_format($product->price, 2) }}">
<meta property="product:price:currency" content="KES">
<meta property="product:availability" content="in stock">

@endsection


@section('main')




<!-- Page Header Start -->
<section class="page-header">
    <div class="page-header-bg" style="background-image: url({{ asset('dark/assets/img/gallery/header-bg.png') }});">
    </div>
    <div class="container">
        <div class="page-header__inner text-center">
            <h1 class="">{{ $product->name }}</h1>
            <p class="">Your perfect solution for high-speed internet connectivity.</p>
        </div>
    </div>
</section>
<!-- Page Header End -->

<!-- Product Details Start -->
<section class="product-details py-5">
    <div class="container">
        <div class="row align-items-center">
            <!-- Product Image -->
            <div class="col-lg-6 mb-4">
                <div class="product-details__img">
                  

@if($mediafiles->count()>0)
                        <!-- Image Slider -->
            <div id="tourImagesCarousel" class="carousel slide shadow" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($mediafiles as $index => $media)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ $media->file_path }}" 
                                 class="d-block w-100 img-fluid rounded modal-trigger" 
                                 alt="{{ $product->name }}" 
                                 data-bs-toggle="modal" 
                                 data-bs-target="#imageModal" 
                                 data-index="{{ $index }}">
                </div>
                    @endforeach
                </div>
                
                <button class="carousel-control-prev" type="button" data-bs-target="#tourImagesCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#tourImagesCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>


            <!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-body p-0 position-relative">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <img id="modalImage" src="" class="img-fluid rounded" alt="Full Size Image">
            </div>
            <div class="modal-footer justify-content-between">
                <button id="prevImage" type="button" class="btn btn-outline-dark px-4">Previous</button>
                <button id="nextImage" type="button" class="btn btn-outline-dark px-4">Next</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modalImage = document.getElementById('modalImage');
        const mediafiles = @json($mediafiles);
        let currentIndex = 0;

        // Function to update the modal image
        function updateModalImage(index) {
            if (index >= 0 && index < mediafiles.length) {
                currentIndex = index;
                modalImage.src = mediafiles[index].file_path;
            }
        }

        // Event listener for image click
        document.querySelectorAll('.modal-trigger').forEach((image, index) => {
            image.addEventListener('click', () => {
                currentIndex = parseInt(image.getAttribute('data-index'));
                updateModalImage(currentIndex);
            });
        });

        // Event listeners for Next and Previous buttons
        document.getElementById('prevImage').addEventListener('click', () => {
            const prevIndex = (currentIndex - 1 + mediafiles.length) % mediafiles.length;
            updateModalImage(prevIndex);
        });

        document.getElementById('nextImage').addEventListener('click', () => {
            const nextIndex = (currentIndex + 1) % mediafiles.length;
            updateModalImage(nextIndex);
        });
    });
</script>
@else
  <img src="/images?path={{ $product->photo }}" alt="{{ $product->name }}" class="img-fluid rounded shadow" />
@endif





                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-details__top">
                    <h3 class="product-details__title text-dark">{{ $product->name }}</h3>
                    <h4 class="product-details__price text-dark">KES {{ number_format($product->price, 2) }}</h4>
                </div>
                <div class="product-details__review mb-3">
                    @for($i = 0; $i < 5; $i++)
                        <i class="fa fa-star text-warning"></i>
                    @endfor
                </div>
                <div class="product-details__content">
                    <p class="product-details__content-text">
                        @php
                            use Illuminate\Support\Str;
                        @endphp
                        {!! Str::words(strip_tags($product->description), 40, '...') !!}
                    </p>
                    <p class="product-details__availability text-muted">
                        {{ $product->quantity > 0 ? 'Available in store' : 'Out of stock' }}
                    </p>
                </div>

                <!-- Buy Now or Notify Button -->
                <div class="product-details__buttons mt-4">
                    @if($product->quantity > 0)

                    @if($product->has_price == 1)
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-dark btn-lg">Buy Now</button>
                        </form>
                        @else
   <!-- Notify Me Button -->
                        <button type="button" class="btn btn-dark btn-lg" data-bs-toggle="modal" data-bs-target="#quoteModal">
                            Get Quote
                        </button>
                        @endif
                    @else
                        <!-- Notify Me Button -->
                        <button type="button" class="btn btn-dark btn-lg" data-bs-toggle="modal" data-bs-target="#notifyModal">
                            Notify Me
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Details End -->

<!-- Modal for Notify Me -->
<div class="modal fade" id="notifyModal" tabindex="-1" aria-labelledby="notifyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notifyModalLabel">Notify Me</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">This item is currently out of stock. Enter your details below to be notified when it's back in stock.</p>
                <form id="notifyForm" action="{{ route('notify.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="notification_type" value="quote">
                     <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Notify Me</button>
                </form>

                @if(session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal for Quote Me -->
<div class="modal fade" id="quoteModal" tabindex="-1" aria-labelledby="notifyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notifyModalLabel">Share a quote with me</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Enter your details below to be notified when it's back in stock.</p>
                <form id="notifyForm" action="{{ route('notify.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="notification_type" value="quote">
                     <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Notify Me</button>
                </form>

                @if(session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Product Description Start -->
<section class="product-description py-6 bg-light">
    <div class="container">
        <h3 class="product-description__title">Description</h3>
        <p>{!! $product->description !!}</p>
    </div>
</section>
<!-- Product Description End -->

@endsection

@section('styles')
<style>
    .page-header {
        position: relative;
        text-align: center;
        color: #fff;
    }

    .page-header-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        filter: brightness(0.5);
    }

    .product-details__title {
        font-size: 1.75rem;
        font-weight: bold;
    }

    .product-details__price {
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .product-description__title {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        font-weight: bold;
    }

    .btn {
        border-radius: 50px;
        padding: 10px 20px;
    }

    .modal-content {
        border-radius: 15px;
        padding: 20px;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
