<div class="card">

    <div class="card-header">
            <h3 class="mb-4">Uploaded Media</h3>
    </div>

<div class="card-body">
    @if($mediaFiles->count() > 0)
        <div class="row">
            @foreach($mediaFiles as $media)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <!-- Display Image -->
                        <img src="{{ $media->file_path }}" class="card-img-top" alt="{{ $media->name }}" style="height: 200px; object-fit: cover;">

                        <!-- Card Body -->
                        <div class="card-body">
                            <h5 class="card-title">{{ $media->name }}</h5>
                            <p class="card-text">
                                <strong>Type:</strong> {{ ucfirst($media->media_type) }} <br>
                                <strong>Uploaded:</strong> {{ $media->created_at->format('d M Y') }}
                            </p>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer text-center">
                            <a href="{{ $media->file_path }}" class="btn btn-primary btn-sm" target="_blank">View</a>
                            <form action="{{ route('medias.destroy', $media->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No media files uploaded yet.</p>
    @endif
</div>
</div>