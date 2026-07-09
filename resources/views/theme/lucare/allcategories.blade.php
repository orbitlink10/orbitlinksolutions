@extends('theme.lucare.layouts.main')
@section('title') {{ get_option('hero_header_title') }} @endsection
@section('meta_description', get_option('hero_header_description'))
@section('main')
<section class="featured position-relative py-5">
    <div class="container">
        <div class="row g-4">
            @foreach($categories as $category)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('view_product_category', ['slug' => $category->slug]) }}" class="text-decoration-none text-dark">
                        <div class="card category-card border-0 shadow-sm h-100">
                            <div class="card-img-top position-relative overflow-hidden">
                                <img src="{{ $category->photo }}" 
                                     alt="{{ $category->name }}"
                                     class="img-fluid w-100 h-100 object-fit-cover">
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
            @endforeach
        </div>
        <!-- View All Categories Button -->
        <div class="text-center mt-4">
            <a href="{{ route('allcategories') }}" class="btn btn-primary">View All Categories</a>
        </div>
    </div>
</section>
@endsection
