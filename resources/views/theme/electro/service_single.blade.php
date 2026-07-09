@extends('theme.electro.layouts.main')

@section('title', $service->name)
@section('meta_description', $service->meta_description)

@section('main')
<div class="container my-5">
    <!-- Image Carousel -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div id="service-carousel" class="carousel slide" data-bs-ride="carousel">
                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    @foreach($mediaFiles as $index => $image)
                        <button type="button" data-bs-target="#service-carousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>

                <!-- Carousel Images -->
                <div class="carousel-inner rounded-4 shadow-sm">
                    @foreach($mediaFiles as $index => $image)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ $image->file_path }}" class="d-block w-100" alt="Service {{ $service->name }}" style="height: 450px; object-fit: contain;">
                        </div>
                    @endforeach
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#service-carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#service-carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Service Description -->
    <section class="py-5" id="homepage-description">
        <div class="container">
            <h2 class="text-center mb-4 text-success fw-bold">{{ $service->name }}</h2>
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="text-muted fs-5">
                        {!! $service->description !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('styles')
@endsection

@section('scripts')
@endsection
