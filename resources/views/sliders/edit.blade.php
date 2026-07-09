{{-- resources/views/sliders/edit.blade.php --}}
@extends('layouts.appbar')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark d-flex align-items-center">
                    <i class="bi bi-pencil-square me-2"></i>
                    <h5 class="mb-0">Edit Slider</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('sliders.update', $slider) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- ─────────────── Slider fields (reuse partial) ─────────────── --}}
                        @include('sliders.partials.form', ['slider' => $slider])

                        <!-- Live preview -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Preview</label>
                            <div id="mediaPreview"
                                 class="border rounded d-flex align-items-center justify-content-center p-2"
                                 style="min-height:180px; background:#fafafa">
                                <small class="text-muted">
                                    Enter or edit the Image / Video URL to preview here…
                                </small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle me-1"></i> Update Slider
                        </button>
                    </form>
                </div>
            </div><!-- /card -->

        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const urlInput = document.querySelector('input[name="img_url"]');
    const preview  = document.getElementById('mediaPreview');
    if (!urlInput || !preview) return;

    function renderPreview(src){
        preview.innerHTML = '';                              // reset
        if(!src){
            preview.innerHTML =
              '<small class="text-muted">Enter or edit the Image / Video URL to preview here…</small>';
            return;
        }

        const isVideo = /(mp4|webm|ogg)$/i.test(src);
        const isYou   = /youtu\.?be/.test(src);
        const isVim   = /vimeo\.com/.test(src);
        let node;

        if(isVideo){
            node = document.createElement('video');
            Object.assign(node, {src, muted:true, loop:true, autoplay:true});
            node.className = 'w-100 rounded';
        }else if(isYou){
            const id = src.match(/(youtu\.be\/|v=)([^&/]+)/)?.[2] ?? '';
            node = document.createElement('iframe');
            node.src = `https://www.youtube.com/embed/${id}?autoplay=0&mute=1`;
            Object.assign(node.style, {aspectRatio:'16/9'});
            node.className = 'w-100 rounded border-0';
        }else if(isVim){
            const id = src.match(/vimeo\.com\/(?:video\/)?(\d+)/)?.[1] ?? '';
            node = document.createElement('iframe');
            node.src = `https://player.vimeo.com/video/${id}`;
            Object.assign(node.style, {aspectRatio:'16/9'});
            node.className = 'w-100 rounded border-0';
        }else{
            node = document.createElement('img');
            node.src = src;
            node.className = 'img-fluid rounded';
        }
        preview.appendChild(node);
    }

    renderPreview(urlInput.value.trim());          // initial (existing value)
    urlInput.addEventListener('input', e => renderPreview(e.target.value.trim()));
});
</script>
@endpush
