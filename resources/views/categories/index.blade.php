<!-- resources/views/categories/index.blade.php -->

@extends('layouts.appbar') 
{{-- This layout should include Bootstrap 5 CSS and JS --}}

@section('content')
<div class="content-wrapper">

    @include('flash_msg')

    <div class="container py-4">
        {{-- Page Header & "Create" Button --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3">Categories</h1>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> {{-- Optional Bootstrap Icon --}}
                Create New Category
            </a>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Table of Categories --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="width: 60px;">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Photo</th>
                        <th scope="col" style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                @if($category->photo)
                                    <img src="{{ $category->photo }}" 
                                         alt="{{ $category->name }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 100px;">
                                @else
                                    <span class="text-muted">No Photo</span>
                                @endif
                            </td>
                            <td>
                                {{-- Action Buttons --}}
                                <div class="btn-group" role="group">
                                    {{-- Show details --}}
                                    <a href="{{ route('categories.show', $category->id) }}"
                                       class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i> Show
                                    </a>
                                    
                                    {{-- Edit --}}
                                    <a href="{{ route('categories.edit', $category->id) }}"
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    
                                    {{-- Delete --}}
                                    <form action="{{ route('categories.destroy', $category->id) }}"
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <strong>No categories found.</strong>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div> <!-- /table-responsive -->
    </div> <!-- /container -->
</div> <!-- /content-wrapper -->
@endsection
