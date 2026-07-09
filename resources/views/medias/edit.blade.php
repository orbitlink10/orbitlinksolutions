@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="page-title">Edit Media</h1>
                <p class="text-muted">Update the details of the media</p>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('medias.update', $media->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $media->name }}" required>
                            </div>


                            <div class="form-group">
                                <label>Type:</label>
                                <select name="media_type" class="form-control" required>
                                    <option value="{{ $media->media_type }}">{{ $media->media_type }}</option>
                                    <option value="installation">installation</option>
                                    <option value="media">media</option>
                                    <option value="video">video</option>
                              </select>
                                
                            </div>

                            <div class="form-group">
                                <label for="file_path">File:</label>
                                <div class="mb-2">
                                    <a href="{{ Storage::url($media->file_path) }}" target="_blank">View Current File</a>
                                </div>
                                <input type="file" class="form-control" id="file_path" name="file_path">
                                <small class="text-muted">Leave blank to keep the current file.</small>
                            </div>

                            <button type="submit" class="btn btn-primary shadow-sm">Update</button>
                            <a href="{{ route('medias.index') }}" class="btn btn-secondary shadow-sm">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
