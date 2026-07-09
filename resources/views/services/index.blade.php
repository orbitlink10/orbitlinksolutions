@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center mb-3">
                    <div class="col-sm-6">
                        <h1 class="page-title">Services</h1>
                        <p class="text-muted">Manage and view all services offered</p>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('service.create') }}" class="btn btn-primary shadow-sm">
                            <i class="fas fa-plus"></i> Add Service
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold">Service List</h3>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-hover table-bordered">
                            @include('flash_msg')
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                     <th>Category</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($services as $key => $service)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                         <td><img src="{{ $service->image_url }}" style="width: 150px;"> 
                        </td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ Str::limit($service->description, 50) }}</td>
                                        <td>{{ number_format($service->price, 2) }}</td>
                                        <td>
                                            <a href="{{ route('service.edit', $service) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                                            <form action="{{ route('service.destroy', $service) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No services found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-white">
                        {{ $services->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
