@extends('layouts.appbar')

@section('content')
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="page-title">{{ $testimonial->name }}</h1>
                <p class="text-muted">Details of the testimonial</p>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <p><strong>Description:</strong> {{ $testimonial->description }}</p>
                        <p><strong>Rating:</strong> {{ $testimonial->rating_count }}</p>
                        <a href="{{ route('testimonials.index') }}" class="btn btn-secondary shadow-sm">Back to List</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
