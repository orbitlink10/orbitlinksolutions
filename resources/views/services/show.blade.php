@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="page-title">Service Details</h1>
                <p class="text-muted">Details of the selected service</p>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label><strong>Name:</strong></label>
                            <p>{{ $service->name }}</p>
                        </div>
                        <div class="form-group">
                            <label><strong>Description:</strong></label>
                            <p>{{ $service->description }}</p>
                        </div>
                        <div class="form-group">
                            <label><strong>Price:</strong></label>
                            <p>{{ number_format($service->price, 2) }}</p>
                        </div>

                        <a href="{{ route('service.index') }}" class="btn btn-secondary shadow-sm">Back to List</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
