@extends('layouts.appbar')
@section('content')
<div class="content-wrapper">
<div class="container mt-4">
    <h1>Design Details</h1>
    <div class="card">
        <div class="card-body">
            <h3>{{ $design->name }}</h3>
            <p><strong>ID:</strong> {{ $design->id }}</p>
            <p><strong>Created At:</strong> {{ $design->created_at->format('d/m/Y H:i:s') }}</p>
            <p><strong>Updated At:</strong> {{ $design->updated_at->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
    <a href="{{ route('designs.index') }}" class="btn btn-secondary mt-3">Back to Designs</a>
</div>
</div>
@endsection
