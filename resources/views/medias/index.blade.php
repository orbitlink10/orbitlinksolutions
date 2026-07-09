@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center mb-3">
                    <div class="col-sm-6">
                        <h1 class="page-title">Medias</h1>
                        <p class="text-muted">Manage and view all uploaded media files</p>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('medias.create') }}" class="btn btn-primary shadow-sm">
                            <i class="fas fa-plus"></i> Upload Media
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold">Media List</h3>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-hover table-bordered">
             
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                          <th>Type</th>
                                    <th>File</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($medias as $key => $media)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $media->name }}</td>
                                                <td>{{ $media->media_type }}</td>
                                        <td><a target="_blank" href="{{ $media->file_path }}"> <img style="height: 150px;" src="{{ $media->file_path }}"></a></td>
                                        <td>
                                            <a href="{{ route('medias.edit', $media) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                                            <form action="{{ route('medias.destroy', $media) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No media files found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-white">
                        {{ $medias->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
