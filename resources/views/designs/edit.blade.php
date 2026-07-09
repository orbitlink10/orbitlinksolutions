@extends('layouts.appbar')

@section('content')
<div class="content-wrapper">
<div class="container mt-4">
    <h1>Edit Design</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('designs.update', $design->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Design Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $design->name) }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Update Design</button>
        <a href="{{ route('designs.index') }}" class="btn btn-secondary mt-2">Back</a>
    </form>
</div>
</div>
@endsection
