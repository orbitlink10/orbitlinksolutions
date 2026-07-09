@extends('theme.starlinknew.layouts.main')

@section('title', $service->name)
@section('meta_description', $service->meta_description)

@push('meta')
@php
    $siteUrl = rtrim(config('app.url') ?: url('/'), '/');
    $serviceId = 'service-' . ($service->slug ?? $service->id);
    $serviceSchema = [
        '@context' => 'https://schema.org',
        '@type'    => 'Service',
        '@id'      => $siteUrl . '/#' . $serviceId,
        'name'     => $service->name,
        'serviceType' => $service->name,
        'description' => strip_tags($service->meta_description ?: $service->name),
        'provider' => [ '@id' => $siteUrl . '/#organization' ],
        'areaServed' => ['KE'],
        'image'    => $service->image_url ?: get_option('hero_image'),
        'url'      => url()->current(),
    ];

    $breadcrumb = [
        '@context' => 'https://schema.org',
        '@type'    => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => url('/'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $service->name,
                'item' => url()->current(),
            ],
        ],
    ];
@endphp
<script type="application/ld+json">@json($serviceSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)</script>
<script type="application/ld+json">@json($breadcrumb, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)</script>
@endpush

@section('main')
<div class="container my-5">

    <!-- Featured Image -->
    @if($service->image_url)
    <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
        <img src="{{ $service->image_url }}" alt="{{ $service->name }} Featured Image" class="img-fluid rounded-3 shadow w-100" style="object-fit:cover; height:1024px;">
        </div>
    </div>
    @endif

    <!-- Service Description Section -->
    <section id="homepage-description" class="section-py bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h1 class="fw-bold">{{ $service->name }}</h1>
                @if($service->meta_description)
                    <p class="lead text-muted">{{ $service->meta_description }}</p>
                @endif
            </div>

            <div class="service-description">
                {!! $service->description !!}
            </div>
        </div>
    </section>

</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    #homepage-description {
        background-color: #f9f9f9;
        padding: 3rem 0;
    }

    #homepage-description .service-description {
        font-size: 1.125rem;
        line-height: 1.8;
        color: #333;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
@endpush
