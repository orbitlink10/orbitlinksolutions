@extends('theme.lucare.layouts.main')

@section('title', $post->meta_title ?? 'Default Title')
@section('meta_description', $post->meta_description ?? 'Default description here.')

@section('social-meta')
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Meta Description -->
    <meta name="description" content="{{ $post->meta_description ?? 'Default description here.' }}" />

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $post->meta_title ?? 'Default Title' }}" />
    <meta property="og:description" content="{{ $post->meta_description ?? 'Default description here.' }}" />
    <meta property="og:image" content="{{ $post->photo ? asset('storage/' . $post->photo) : asset('default-image.jpg') }}" />
    <meta property="og:image:width" content="1478" />
    <meta property="og:image:height" content="1108" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="{{ config('app.name', 'Lucare') }}" />
    <meta property="og:type" content="website" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="{{ url('/') }}" />
    <meta name="twitter:title" content="{{ $post->meta_title ?? 'Default Title' }}" />
    <meta name="twitter:description" content="{{ $post->meta_description ?? 'Default description here.' }}" />
    <meta name="twitter:image" content="{{ $post->photo ? asset('storage/' . $post->photo) : asset('default-image.jpg') }}" />
@endsection

@section('main')

@push('styles')
<style>
    .uniform-height {
        height: 350px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-content-wrap {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .media-card2 {
        overflow: hidden;
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .media-card2 img {
        transition: transform 0.3s ease;
    }

    .media-card2:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    .media-card2:hover img {
        transform: scale(1.1);
    }
</style>
@endpush

<section id="header" class="py-5" style="background-color: #f9fafc;">
    <div class="container py-5">
        <div class="row align-items-center min-vh-75 min-vh-xl-100">
            <!-- Header Content -->
            <div class="col-md-6 text-md-start text-center mb-4 mb-md-0">
                <h1 class="display-4 fw-bold text-dark mb-3">{{ $post->title }}</h1>
                <p class="lead text-secondary">{{ $post->meta_description }}</p>
                <div class="pt-4">
                    <a class="btn btn-lg btn-dark rounded-pill me-3 px-4 py-2 shadow" href="{{ url('shop') }}">Shop Now</a>
                    <a class="btn btn-lg btn-dark rounded-pill me-3 px-4 py-2 shadow" href="{{ route('contacts') }}">Talk to an Expert</a>
                </div>
            </div>

            <!-- Header Image -->
            <div class="col-md-6 text-center">
                <img class="img-fluid rounded shadow-lg"
                     src="{{ $post->photo ? asset('storage/' . $post->photo) : asset('assets/img/default-placeholder.jpg') }}"
                     alt="{{ $post->title }} image" style="max-width: 90%; border-radius: 20px;">
            </div>
        </div>
    </div>
</section>

@if($medias && $medias->count() > 0)
<section class="bg-light py-5" id="medias">
    <div class="container">
        <div id="mediaCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @foreach($medias->chunk(4) as $key => $mediaChunk)
                    <div class="carousel-item @if($key == 0) active @endif">
                        <div class="row justify-content-center">
                            @foreach($mediaChunk as $media)
                                <div class="col-md-3 col-sm-6 mb-4">
                                    <a href="{{ asset($media->file_path) }}" class="media-card2 position-relative" data-lg-size="1600-1200">
                                        <img src="{{ asset($media->file_path) }}" alt="Media Image" class="img-fluid rounded shadow-sm" style="object-fit: cover; height: 200px; width: 100%;">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#mediaCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mediaCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
@endif

<section class="py-5" id="homepage-description">
    <div class="container">
        {!! $post->description !!}
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/lightgallery/lightgallery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        lightGallery(document.getElementById('mediaCarousel'), {
            selector: '.media-card2',
            download: false,
            mode: 'lg-slide',
            speed: 600,
        });
    });
</script>
@endpush

@endsection
