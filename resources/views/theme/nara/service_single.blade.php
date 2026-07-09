@extends('theme.nara.layouts.main')

@section('title', $service->name)
@section('meta_description', $service->meta_description)

@section('main')
<div class="container mt-5">
    <!-- Image Carousel -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div id="service-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($mediaFiles as $index => $image)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ $image->file_path }}" class="d-block w-100 rounded-3" alt="Service {{ $service->name }}" height="401">
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#service-carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#service-carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>



    <section class="py-5" id="homepage-description">
    <div class="container">
         <h2 class="text-center mb-4">{{ $service->name }}</h2>
  {!! $service->description !!}
    </div>
</section>


</div>
@endsection

@push('styles')
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .carousel-inner .carousel-item img {
        object-fit: cover;
        border-radius: 8px;
    }
</style>
@endpush

@push('scripts')
<!-- Bootstrap 5 JS (including Popper) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
@endpush
