@extends('layouts.appbar')

@section('content')
<div class="content-wrapper">
<div class="container mt-4">
    <h1>Add New Design</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('designs.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Design Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter design name" value="{{ old('name') }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Add Design</button>
        <a href="{{ route('designs.index') }}" class="btn btn-secondary mt-2">Back</a>
    </form>
</div>
</div>
@endsection
