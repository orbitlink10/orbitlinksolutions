@extends('theme.electro.layouts.main')
@section('title', $product->name)
@section('meta_description', $product->meta_description)

@push('meta')
<!-- Canonical URL -->
<link rel="canonical" href="{{ url()->current() }}" />

<!-- Meta Description -->
<meta name="description" content="{{ $product->meta_description }}" />

<!-- Open Graph Meta Tags -->
<meta property="og:title" content="{{ $product->meta_title }}" />
<meta property="og:description" content="{{ $product->meta_description }}" />
<meta property="og:image" content="{{ $product->photo ? url('/') . '/storage/' . $product->photo : asset('default-image.jpg') }}" />
<meta property="og:image:width" content="1478" />
<meta property="og:image:height" content="1108" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="{{ get_option('site_name') }}" />
<meta property="og:type" content="website" />

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="{{ url('/') }}" />
<meta name="twitter:title" content="{{ $product->meta_title }}" />
<meta name="twitter:description" content="{{ $product->meta_description }}" />
<meta name="twitter:image" content="{{ $product->photo ? url('/') . '/storage/' . $product->photo : asset('default-image.jpg') }}" />
@endpush

@section('main')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ url('/') }}" rel="nofollow">Home</a>
            <span></span>
            <a href="{{ route('view_product_category', ['slug' => App\Models\Category::find($product->category_id)->slug]) }}">
                      {{ App\Models\Category::find($product->category_id)->name }}
            </a>
            <span></span> {{ $product->name }}
        </div>
    </div>
</div>

<section class="mt-5 mb-5">
    <div class="container">
        <div class="row">

            <!-- Product Image Section -->
            <div class="col-lg-6">
                <div>
                    <!-- Carousel Section using Bootstrap ratio utilities only -->
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                        <div class="carousel-inner">
                            @if($mediafiles->count() > 0)
                                @foreach($mediafiles as $index => $media)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <div class="ratio ratio-1x1 rounded overflow-hidden">
                                            <img src="{{ $media->file_path }}" alt="{{ $product->name }}" class="w-100 h-100 object-fit-cover" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="openModal('{{ $media->file_path }}', '{{ $index }}')">
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="carousel-item active">
                                    <div class="ratio ratio-1x1 rounded overflow-hidden">
                                        <img src="{{ url('/') }}/storage/{{ $product->photo }}" alt="{{ $product->name }}" class="w-100 h-100 object-fit-cover" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="openModal('{{ url('/') }}/storage/{{ $product->photo }}', '0')">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- Carousel Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <!-- Thumbnails: horizontal scroll with scroll-snap -->
                    <div class="mt-3 position-relative">
                        <button type="button" class="btn btn-light btn-sm position-absolute top-50 start-0 translate-middle-y shadow js-thumbs-prev" aria-label="Scroll left">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div id="thumbsTrack" class="d-flex gap-2 flex-nowrap thumbs-scroll px-4">
                            @if($mediafiles->count() > 0)
                                @foreach($mediafiles as $index => $media)
                                    <div class="thumb-item">
                                        <img src="{{ $media->file_path }}" alt="thumb-{{ $index }}" class="img-thumbnail rounded js-thumb {{ $index==0 ? 'border-primary' : '' }}" data-index="{{ $index }}">
                                    </div>
                                @endforeach
                            @else
                                <div class="thumb-item">
                                    <img src="{{ url('/') }}/storage/{{ $product->photo }}" alt="thumb-0" class="img-thumbnail rounded js-thumb border-primary" data-index="0">
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-light btn-sm position-absolute top-50 end-0 translate-middle-y shadow js-thumbs-next" aria-label="Scroll right">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal for Image Popup with Slider -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <!-- Carousel inside Modal -->
                            <div id="modalCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner" id="modalCarouselInner">
                                    @if($mediafiles->count() > 0)
                                        @foreach($mediafiles as $index => $media)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <div class="ratio ratio-4x3">
                                                    <img src="{{ $media->file_path }}" class="w-100 h-100 object-fit-cover">
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="carousel-item active">
                                            <div class="ratio ratio-4x3">
                                                <img src="{{ url('/') }}/storage/{{ $product->photo }}" class="w-100 h-100 object-fit-cover">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!-- Carousel Controls -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#modalCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            <!-- Modal Thumbnails: horizontal scroll with scroll-snap -->
                            <div class="mt-3 position-relative">
                                <button type="button" class="btn btn-light btn-sm position-absolute top-50 start-0 translate-middle-y shadow js-mthumbs-prev" aria-label="Scroll left">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <div id="modalThumbsTrack" class="d-flex gap-2 flex-nowrap thumbs-scroll px-4 justify-content-center">
                                    @if($mediafiles->count() > 0)
                                        @foreach($mediafiles as $index => $media)
                                            <div class="thumb-item">
                                                <img src="{{ $media->file_path }}" alt="mthumb-{{ $index }}" class="img-thumbnail rounded js-mthumb {{ $index==0 ? 'border-primary' : '' }}" data-index="{{ $index }}">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="thumb-item">
                                            <img src="{{ url('/') }}/storage/{{ $product->photo }}" alt="mthumb-0" class="img-thumbnail rounded js-mthumb border-primary" data-index="0">
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-light btn-sm position-absolute top-50 end-0 translate-middle-y shadow js-mthumbs-next" aria-label="Scroll right">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function openModal(imageUrl, index) {
                    // Ensure the correct slide is shown in the modal carousel, then open modal
                    const modalEl = document.getElementById('modalCarousel');
                    const idx = parseInt(index, 10) || 0;
                    if (modalEl && window.bootstrap && bootstrap.Carousel) {
                        const mcarousel = bootstrap.Carousel.getInstance(modalEl) || new bootstrap.Carousel(modalEl);
                        mcarousel.to(idx);
                    }
                    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
                    modal.show();
                }
            </script>

            <!-- Product Details Section -->
            <div class="col-lg-6">
                <div class="detail-info">
                    <h2 class="title-detail fs-4 fw-bold text-dark">{{ $product->name }}</h2>
                    <div class="product-price-cover mt-3">
                        <div class="product-price">
                            @if($product->has_price)
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <ins><span class="text-brand fs-3">{{ number_format($product->price, 2) }}</span></ins>
                                    <ins><span class="old-price ms-3 text-decoration-line-through">{{ number_format($product->marked_price, 2) }}</span></ins>
                                      @if($product->marked_price)
                                    <span class="save-price ms-3 bg-light p-1 rounded-2 text-success">{{ discount($product->id) }}% Off</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="short-desc mt-3 mb-4">
                        <p class="text-muted">{!! Str::words(strip_tags($product->description), 40, '...') !!}</p>
                    </div>
                    <div class="bt-1 border-color-1 mt-3 mb-4"></div>


                  

                                           

                    @php
                        $rawPhone = get_option('contact_phone');
                        $wa = preg_replace('/\D+/', '', $rawPhone ?? '');
                        if (\Illuminate\Support\Str::startsWith($wa, '0')) { $wa = '254'.\Illuminate\Support\Str::substr($wa, 1); }
                        $waMessage = urlencode("Hi, I'm interested in {$product->name} - ".url()->current());
                        $waLink = $wa ? "https://wa.me/{$wa}?text={$waMessage}" : null;
                    @endphp

                    <div class="detail-extralink">
                        <div class="product-extra-link2">
                            @if($product->quantity > 0)
                                @if($product->has_price)
<form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center flex-wrap gap-3">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <div class="attr-detail attr-size">
        <strong class="mr-10">Size</strong>
        <ul class="list-filter size-filter font-small">
            @forelse($product->sizes as $size)
                <li>
                    <input type="radio" 
                           id="size-{{ $size->id }}" 
                           name="size_id" 
                           value="{{ $size->id }}" 
                           class="radio-custom"
                           {{ old('size', $product->sizes->first()->name) == $size->name ? 'checked' : '' }}>
                    <label for="size-{{ $size->id }}">{{ $size->name }}</label>
                </li>
            @empty
                <li>No sizes available.</li>
            @endforelse
        </ul>
    </div>

    <div class="w-100"></div>
    <div class="d-flex align-items-center flex-wrap gap-2 buy-actions">
        <button type="submit" class="btn btn-primary btn-lg shadow-lg d-inline-flex align-items-center"><i class="fas fa-shopping-cart me-2"></i><span>Buy Now</span></button>
        @if($waLink)
            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-success btn-lg shadow-lg d-inline-flex align-items-center"><i class="fab fa-whatsapp me-2"></i><span>WhatsApp</span></a>
        @endif
    </div>
</form>



<style type="text/css">
    /* Hide the default radio button */
.radio-custom {
    display: none;
}

/* Style the label to look like your existing clickable items */
.radio-custom + label {
    padding: 5px 10px;
    border: 1px solid #ccc;
    cursor: pointer;
    margin-right: 5px;
    /* Add any additional styles to match your UI */
}

/* Highlight the selected size */
.radio-custom:checked + label {
    background-color: #f0f0f0;
    border-color: #333;
    /* Adjust the active state styling as needed */
}

</style>
                                @else
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <button type="button" class="btn btn-dark btn-lg shadow-lg d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#quoteModal">Get Quote</button>
                                        @if($waLink)
                                            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-success btn-lg shadow-lg d-inline-flex align-items-center"><i class="fab fa-whatsapp me-2"></i><span>WhatsApp</span></a>
                                        @endif
                                    </div>
                                @endif
                            @else
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <button type="button" class="btn btn-dark btn-lg shadow-lg d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#notifyModal">Notify Me</button>
                                    @if($waLink)
                                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-success btn-lg shadow-lg d-inline-flex align-items-center"><i class="fab fa-whatsapp me-2"></i><span>WhatsApp</span></a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <ul class="product-meta font-xs text-muted mt-4">
                        @if($product->has_price)
                            <li class="d-flex justify-content-between align-items-center">
                                <span>Availability:</span>
                                <span class="in-stock text-success ms-2">{{ $product->quantity > 0 ? 'Available in store' : 'Out of stock' }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tab Section for Description -->
        <div class="tab-style3 mt-5">
            <ul class="nav nav-tabs text-uppercase">
                <li class="nav-item">
                    <a class="nav-link active" id="Description-tab" data-bs-toggle="tab" href="#Description">Description</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="Description">
                    <div class="container">
                        <div id="homepage-description" class="description-scroll">
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
  /* Horizontal scroll thumbnails */
  .thumbs-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; scroll-snap-type: x mandatory; gap: .5rem; }
  .thumbs-scroll::-webkit-scrollbar { height: 8px; }
  .thumbs-scroll::-webkit-scrollbar-thumb { background: rgba(0,0,0,.15); border-radius: 4px; }
  .thumb-item { scroll-snap-align: start; flex: 0 0 auto; }
  .thumb-item img { cursor: pointer; width: 76px; height: 76px; object-fit: cover; }

  @media (max-width: 576px) {
    .thumb-item { scroll-snap-align: center; }
    .thumb-item img { width: 60px; height: 60px; }
    .thumbs-scroll { gap: .35rem; }
    .js-thumbs-prev, .js-thumbs-next, .js-mthumbs-prev, .js-mthumbs-next { padding: .125rem .35rem; }
    .js-thumbs-prev i, .js-thumbs-next i, .js-mthumbs-prev i, .js-mthumbs-next i { font-size: .85rem; }
  }

  /* Description content scroll only (no sticky) */
  @media (min-width: 992px) {
    .description-scroll {
      max-height: calc(100vh - 180px);
      overflow: auto;
      padding-right: .25rem;
    }
  }
  @media (max-width: 991.98px) {
    .description-scroll { max-height: 50vh; overflow: auto; }
  }
  #homepage-description img { max-width: 100%; height: auto; }
  #homepage-description table { width: 100%; }
  #homepage-description iframe { max-width: 100%; }
</style>
@endsection

@section('scripts')
<script>
  (function(){
    // Helper to keep active thumbnail centered in its track
    function scrollThumbIntoView(track, el){
      if (!track || !el) return;
      try {
        el.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
      } catch (e) {
        var er = el.getBoundingClientRect();
        var tr = track.getBoundingClientRect();
        var centerDelta = (er.left + er.width/2) - (tr.left + tr.width/2);
        track.scrollBy({ left: centerDelta, behavior: 'smooth' });
      }
    }

    // Horizontal thumbs scroll controls (main)
    var tPrev = document.querySelector('.js-thumbs-prev');
    var tNext = document.querySelector('.js-thumbs-next');
    var tTrack = document.getElementById('thumbsTrack');
    function hScroll(el, dir){ if (!el) return; el.scrollBy({ left: dir * (el.clientWidth * 0.9), behavior: 'smooth' }); }
    function updateControls(track, prev, next){
      if (!track || !prev || !next) return;
      var canScroll = track.scrollWidth > track.clientWidth + 4;
      prev.classList.toggle('d-none', !canScroll);
      next.classList.toggle('d-none', !canScroll);
      if (!canScroll) return;
      prev.disabled = track.scrollLeft <= 4;
      next.disabled = (track.scrollLeft + track.clientWidth) >= (track.scrollWidth - 4);
    }
    if (tPrev && tTrack) tPrev.addEventListener('click', function(){ hScroll(tTrack, -1); });
    if (tNext && tTrack) tNext.addEventListener('click', function(){ hScroll(tTrack, 1); });
    if (tTrack && tPrev && tNext) {
      tTrack.addEventListener('scroll', function(){ updateControls(tTrack, tPrev, tNext); }, { passive: true });
      window.addEventListener('resize', function(){ updateControls(tTrack, tPrev, tNext); });
      updateControls(tTrack, tPrev, tNext);
    }

    // Horizontal thumbs scroll controls (modal)
    var mtPrev = document.querySelector('.js-mthumbs-prev');
    var mtNext = document.querySelector('.js-mthumbs-next');
    var mtTrack = document.getElementById('modalThumbsTrack');
    if (mtPrev && mtTrack) mtPrev.addEventListener('click', function(){ hScroll(mtTrack, -1); });
    if (mtNext && mtTrack) mtNext.addEventListener('click', function(){ hScroll(mtTrack, 1); });
    if (mtTrack && mtPrev && mtNext) {
      mtTrack.addEventListener('scroll', function(){ updateControls(mtTrack, mtPrev, mtNext); }, { passive: true });
      window.addEventListener('resize', function(){ updateControls(mtTrack, mtPrev, mtNext); });
      updateControls(mtTrack, mtPrev, mtNext);
    }
    // Thumbnails click -> change main carousel
    var thumbs = document.querySelectorAll('.js-thumb');
    var carouselEl = document.getElementById('productCarousel');
    if (carouselEl && thumbs.length) {
      var carousel = bootstrap.Carousel.getInstance(carouselEl) || new bootstrap.Carousel(carouselEl);
      var tTrack = document.getElementById('thumbsTrack');
      thumbs.forEach(function(t){
        t.addEventListener('click', function(){
          var idx = parseInt(this.getAttribute('data-index')) || 0;
          carousel.to(idx);
          thumbs.forEach(function(e){ e.classList.remove('border-primary'); });
          this.classList.add('border-primary');
          scrollThumbIntoView(tTrack, this);
        });
      });
      carouselEl.addEventListener('slid.bs.carousel', function (e) {
        var idx = (e.detail ? e.detail.to : e.to);
        thumbs.forEach(function(e){ e.classList.remove('border-primary'); });
        var active = document.querySelector('.js-thumb[data-index="'+idx+'"]');
        if (active) {
          active.classList.add('border-primary');
          var tTrackNow = document.getElementById('thumbsTrack');
          scrollThumbIntoView(tTrackNow, active);
        }
      });
    }

    // Modal thumbnails click -> change modal carousel
    var modalEl = document.getElementById('modalCarousel');
    var mthumbs = document.querySelectorAll('.js-mthumb');
    if (modalEl && mthumbs.length) {
      var mcarousel = bootstrap.Carousel.getInstance(modalEl) || new bootstrap.Carousel(modalEl);
      var mtTrack = document.getElementById('modalThumbsTrack');
      mthumbs.forEach(function(t){
        t.addEventListener('click', function(){
          var idx = parseInt(this.getAttribute('data-index')) || 0;
          mcarousel.to(idx);
          mthumbs.forEach(function(e){ e.classList.remove('border-primary'); });
          this.classList.add('border-primary');
          scrollThumbIntoView(mtTrack, this);
        });
      });
      modalEl.addEventListener('slid.bs.carousel', function (e) {
        var idx = (e.detail ? e.detail.to : e.to);
        mthumbs.forEach(function(e){ e.classList.remove('border-primary'); });
        var active = document.querySelector('.js-mthumb[data-index="'+idx+'"]');
        if (active) {
          active.classList.add('border-primary');
          var mtTrackNow = document.getElementById('modalThumbsTrack');
          scrollThumbIntoView(mtTrackNow, active);
        }
      });
    }

    // Sticky CTA show/hide
    var sticky = document.getElementById('stickyCTA');
    var showAt = 400; // px
    function onScroll(){ if (!sticky) return; if (window.scrollY > showAt) sticky.classList.add('show'); else sticky.classList.remove('show'); }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    // Removed sticky pass-through: default page scroll behavior restored
  })();
</script>
@endsection

{{-- Sticky CTA Bar --}}
@php
    $rawPhone = get_option('contact_phone');
    $wa = preg_replace('/\D+/', '', $rawPhone ?? '');
    if (\Illuminate\Support\Str::startsWith($wa, '0')) { $wa = '254'.\Illuminate\Support\Str::substr($wa, 1); }
    $waMessage = urlencode("Hi, I'm interested in {$product->name} - ".url()->current());
    $waLinkSticky = $wa ? "https://wa.me/{$wa}?text={$waMessage}" : null;
@endphp
<div id="stickyCTA" class="fixed-bottom bg-white border-top shadow-sm py-2 d-none">
  <div class="container d-flex align-items-center justify-content-between gap-3">
    <div class="d-none d-md-block text-truncate">
      <span class="title text-truncate">{{ $product->name }}</span>
      @if($product->has_price)
        <span class="ms-2 fw-bold text-brand">{{ number_format($product->price, 2) }}</span>
      @else
        <span class="ms-2 text-muted">Get a quote</span>
      @endif
    </div>
    <div class="ms-auto d-flex align-items-center gap-2">
      @if($product->quantity > 0)
        @if($product->has_price)
          <a href="#" onclick="document.querySelector('[type=\\'submit\\']')?.click(); return false;" class="btn btn-primary btn-sm"><i class="fas fa-shopping-cart me-1"></i>Buy Now</a>
        @else
          <a href="#quoteModal" data-bs-toggle="modal" class="btn btn-dark btn-sm">Get Quote</a>
        @endif
      @else
        <a href="#notifyModal" data-bs-toggle="modal" class="btn btn-dark btn-sm">Notify Me</a>
      @endif
      @if($waLinkSticky)
        <a href="{{ $waLinkSticky }}" target="_blank" rel="noopener" class="btn btn-success btn-sm d-inline-flex align-items-center"><i class="fab fa-whatsapp me-1"></i><span>WhatsApp</span></a>
      @endif
    </div>
  </div>
</div>

