@extends('theme.orbit.layouts.main')

@section('title', 'All Categories')
@section('meta_description', 'Browse every product category available at ' . get_option('site_name', 'Orbitlink Solutions') . '.')

@section('main')
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fs-2 mb-3 text-black">All Categories</h1>
            <p class="text-muted mb-0">Explore our complete catalog and jump straight to the products you need.</p>
        </div>
        <div class="row g-4">
            @forelse($categories as $category)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('view_product_category', ['slug' => $category->slug]) }}" class="text-decoration-none text-dark d-block h-100">
                        <div class="card category-card border-0 shadow-sm h-100">
                            <div class="card-img-top position-relative overflow-hidden">
                                <img src="{{ $category->photo }}"
                                     alt="{{ $category->name }}"
                                     class="img-fluid w-100 h-100 object-fit-cover"
                                     loading="lazy">
                                <div class="overlay d-flex align-items-center justify-content-center">
                                    <h5 class="text-white fw-bold m-0">{{ $category->name }}</h5>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h6 class="card-title mb-0">{{ $category->name }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center mb-0">
                        Categories will be listed here as soon as they are available.
                    </div>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-5">
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">Back to Home</a>
        </div>
    </div>
</section>
@endsection
