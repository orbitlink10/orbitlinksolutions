@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="page-title">Media Details</h1>
                <p class="text-muted">Details of the selected media</p>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label><strong>Name:</strong></label>
                            <p>{{ $media->name }}</p>
                        </div>

                        <div class="form-group">
                            <label><strong>File:</strong></label>
                            <p><a href="{{ Storage::url($media->file_path) }}" target="_blank">View File</a></p>
                        </div>

                        <a href="{{ route('medias.index') }}" class="btn btn-secondary shadow-sm">Back to List</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
