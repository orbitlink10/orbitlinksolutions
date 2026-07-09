@extends('layouts.appbar')

@section('content')

<div class="content-wrapper">
<div class="container mt-4">
    <h1>Designs</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('designs.create') }}" class="btn btn-primary mb-3">Add New Design</a>

    @if($designs->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Design Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($designs as $design)
                    <tr>
                        <td>{{ $design->id }}</td>
                        <td>{{ $design->name }}</td>
                        <td>
                            <a href="{{ route('designs.show', $design->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('designs.edit', $design->id) }}" class="btn btn-warning btn-sm">Edit</a>


                            <a href="{{ route('designs.design', $design->id) }}" class="btn btn-info btn-sm">Design</a>


                            <form action="{{ route('designs.destroy', $design->id) }}" method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this design?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No designs found.</p>
    @endif
</div>
</div>
@endsection
