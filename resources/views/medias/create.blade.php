@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="page-title">Upload Media</h1>
                <p class="text-muted">Upload a new media file</p>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('medias.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                                                        <div class="form-group">
                                <label>Type:</label>
                                <select name="media_type" class="form-control" required>
                                    <option value="" selected >Select media type</option>
                                    <option value="installation">installation</option>
                                    <option value="media">media</option>
                                    <option value="video">video</option>
                                </select>
                                
                            </div>


                            <div class="form-group">
                                <label>File:</label>
                                <input type="file" name="file_path" class="form-control" required>
                            </div>
                            <button class="btn btn-primary">Upload</button>
                            <a href="{{ route('medias.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
