{{-- resources/views/admin/sliders/_form.blade.php --}}
<div class="form-group">
    <label>H1 Title</label>
    <input type="text" name="h1_title" class="form-control"
           value="{{ old('h1_title', $slider->h1_title ?? '') }}">
</div>

<div class="form-group">
    <label>H2 Title</label>
    <input type="text" name="h2_title" class="form-control"
           value="{{ old('h2_title', $slider->h2_title ?? '') }}">
</div>

<div class="form-group">
    <label>H4 Title</label>
    <input type="text" name="h4_title" class="form-control"
           value="{{ old('h4_title', $slider->h4_title ?? '') }}">
</div>

<div class="form-group">
    <label>Description</label>
    <textarea name="description"
              class="form-control"
              rows="3">{{ old('description', $slider->description ?? '') }}</textarea>
</div>

<div class="form-group">
    <label>Button URL</label>
    <input type="url" name="button_url" class="form-control"
           value="{{ old('button_url', $slider->button_url ?? '') }}">
</div>

<div class="form-group">
    <label>Button Text</label>
    <input type="text" name="button_text" class="form-control"
           value="{{ old('button_text', $slider->button_text ?? '') }}">
</div>

<div class="form-group">
    <label>Image / Video URL</label>
    <input type="url" name="img_url" class="form-control"
           value="{{ old('img_url', $slider->img_url ?? '') }}">
    <small class="form-text text-muted">
        Accepts <code>.jpg</code>, <code>.png</code>, <code>.webp</code> or HTML5 video files
        (<code>.mp4</code>, <code>.webm</code>, <code>.ogg</code>).  
        Remote links (e.g.&nbsp;YouTube) are also allowed.
    </small>
</div>
