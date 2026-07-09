<!-- resources/views/categories/show.blade.php -->

@extends('layouts.appbar') 
{{-- Ensure your layout includes Bootstrap 5 CSS/JS --}}

@section('content')
<div class="content-wrapper">
    <div class="container py-4">

        <h1 class="mb-4">Category Details</h1>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <p><strong>ID:</strong> {{ $category->id }}</p>
                <p><strong>Name:</strong> {{ $category->name }}</p>
                <p><strong>Slug:</strong> {{ $category->slug }}</p>

                @if($category->meta_description)
                    <p>
                        <strong>Meta Description:</strong><br>
                        {{ $category->meta_description }}
                    </p>
                @else
                    <p><strong>Meta Description:</strong> None provided.</p>
                @endif

                {{-- If your description may contain HTML (from TinyMCE or another editor): --}}
                @if($category->description)
                    <div class="mb-3">
                        <strong>Description:</strong><br>
                        {{-- Display description as raw HTML --}}
                        {!! $category->description !!}
                    </div>
                @else
                    <p><strong>Description:</strong> None provided.</p>
                @endif

                {{-- Display Photo if Available --}}
                @if($category->photo)
                    <p>
                        <strong>Photo:</strong><br>
                        <img src="{{ $category->photo }}" alt="{{ $category->name }}" class="img-thumbnail" style="max-width: 200px;">
                    </p>
                @else
                    <p><strong>Photo:</strong> None available.</p>
                @endif

                {{-- Back to index --}}
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    Back to Categories
                </a>
            </div>
        </div> <!-- /card -->

    </div> <!-- /container -->
</div> <!-- /content-wrapper -->
@endsection
