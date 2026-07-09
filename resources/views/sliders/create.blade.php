{{-- resources/views/sliders/create.blade.php --}}
@extends('layouts.appbar')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="bi bi-images me-2"></i>
                    <h5 class="mb-0">Add Slider</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('sliders.store') }}" method="POST">
                        @csrf
                        {{-- ───────────────────── Partial Form ───────────────────── --}}
                        @include('sliders.partials.form')

                        <!-- Live preview -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Preview</label>
                            <div id="mediaPreview"
                                 class="border rounded d-flex align-items-center justify-content-center p-2"
                                 style="min-height:180px; background:#fafafa">
                                <small class="text-muted">Enter a URL above to preview image or video…</small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle me-1"></i> Save Slider
                        </button>
                    </form>
                </div>
            </div><!-- /card -->

        </div>
    </div>
</div>
@endsection

@push('styles')
    {{-- Bootstrap Icons (if not globally loaded) --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    // Grab the Image / Video URL field from the included partial:
    const urlInput = document.querySelector('input[name="img_url"]');
    const preview  = document.getElementById('mediaPreview');

    if (!urlInput || !preview) return;

    function updatePreview () {
        const src = urlInput.value.trim();
        preview.innerHTML = '';                 // reset
        if (!src) {
            preview.innerHTML =
                '<small class="text-muted">Enter a URL above to preview image or video…</small>';
            return;
        }

        // very lightweight tests
        const isVideo = /(mp4|webm|ogg)$/i.test(src);
        const isYouTube = /youtu\.?be/.test(src);
        const isVimeo   = /vimeo\.com/.test(src);

        let node;

        if (isVideo) {
            node = document.createElement('video');
            node.src   = src;
            node.muted = true;
            node.loop  = true;
            node.autoplay = true;
            node.className = 'w-100 rounded';
        } else if (isYouTube) {
            const id = src.match(/(youtu\.be\/|v=)([^&/]+)/)?.[2] ?? '';
            node = document.createElement('iframe');
            node.src = `https://www.youtube.com/embed/${id}?autoplay=0&mute=1`;
            node.style.aspectRatio = '16/9';
            node.className = 'w-100 rounded border-0';
        } else if (isVimeo) {
            const id = src.match(/vimeo\.com\/(?:video\/)?(\d+)/)?.[1] ?? '';
            node = document.createElement('iframe');
            node.src = `https://player.vimeo.com/video/${id}`;
            node.style.aspectRatio = '16/9';
            node.className = 'w-100 rounded border-0';
        } else {
            node = document.createElement('img');
            node.src = src;
            node.className = 'img-fluid rounded';
        }

        preview.appendChild(node);
    }

    updatePreview();          // on load (old value)
    urlInput.addEventListener('input', updatePreview);
});
</script>
@endpush
