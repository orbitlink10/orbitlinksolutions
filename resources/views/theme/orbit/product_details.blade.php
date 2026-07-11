@extends('theme.orbit.layouts.main')
@section('title', $product->name)
@section('meta_description', $product->meta_description)
@php
    $productImageUrl = uploaded_image_url($product->photo, asset('default-image.jpg'));
@endphp

@push('meta')
<!-- Open Graph Meta Tags -->
<meta property="og:title" content="{{ $product->meta_title }}" />
<meta property="og:description" content="{{ $product->meta_description }}" />
<meta property="og:image" content="{{ $productImageUrl }}" />
<meta property="og:image:width" content="1478" />
<meta property="og:image:height" content="1108" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="{{ get_option('site_name') }}" />
<meta property="og:type" content="product" />
@if($product->has_price)
    <meta property="product:price:amount" content="{{ number_format($product->price, 2, '.', '') }}" />
    <meta property="product:price:currency" content="{{ get_option('currency_code', 'KES') }}" />
@endif

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="{{ url('/') }}" />
<meta name="twitter:title" content="{{ $product->meta_title }}" />
<meta name="twitter:description" content="{{ $product->meta_description }}" />
<meta name="twitter:image" content="{{ $productImageUrl }}" />
@php
    $schemaImages = [];
    if ($mediafiles->count() > 0) {
        foreach ($mediafiles as $media) {
            if (!empty($media->file_path)) {
                $schemaImages[] = uploaded_image_url($media->file_path);
            }
        }
    } elseif (!empty($product->photo)) {
        $schemaImages[] = $productImageUrl;
    }
    $schemaDesc = $product->meta_description ?: \Illuminate\Support\Str::words(strip_tags($product->description), 30, '');
    $currencyCode = get_option('currency_code', 'KES');
    $productSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $product->name,
        'image' => $schemaImages,
        'description' => $schemaDesc,
        'sku' => (string) $product->id,
        'brand' => [
            '@type' => 'Brand',
            'name' => get_option('site_name', 'Orbitlink Solutions'),
        ],
    ];
    if ($product->has_price) {
        $productSchema['offers'] = [
            '@type' => 'Offer',
            'url' => url()->current(),
            'priceCurrency' => $currencyCode,
            'price' => (float) $product->price,
            'availability' => $product->quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            'itemCondition' => 'https://schema.org/NewCondition',
        ];
    }
@endphp
<script type="application/ld+json">
    @json($productSchema)
</script>
@endpush

@section('main')
@php
    $category = category($product->category_id);
    $currency = get_option('currency_symbol', 'KES');
    $hasSale = $product->has_price && $product->marked_price && $product->marked_price > $product->price;
@endphp
<div class="page-header breadcrumb-wrap product-breadcrumb-wrap">
    <div class="container">
        <nav aria-label="Breadcrumb">
            <ol class="product-breadcrumb">
                <li class="product-breadcrumb-item">
                    <a href="{{ url('/') }}" rel="nofollow">Home</a>
                </li>
                @if($category)
                    <li class="product-breadcrumb-item product-breadcrumb-category">
                        <a href="{{ route('view_product_category', ['slug' => $category->slug]) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endif
                <li class="product-breadcrumb-item current" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<section class="product-detail-section">
    <div class="container">
        <div class="row g-4 product-detail-hero">

            <!-- Product Image Section -->
            <div class="col-lg-6">
                <div class="product-gallery-card">
                    <!-- Carousel Section using Bootstrap ratio utilities only -->
                    <div id="productCarousel" class="carousel slide product-carousel" data-bs-ride="carousel" data-bs-interval="3000">
                        <div class="carousel-inner">
                            @if($mediafiles->count() > 0)
                                @foreach($mediafiles as $index => $media)
                                    @php
                                        $mediaUrl = uploaded_image_url($media->file_path);
                                    @endphp
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <div class="ratio ratio-1x1 rounded overflow-hidden">
                                            <img src="{{ $mediaUrl }}" alt="{{ $product->name }}" class="w-100 h-100 product-detail-image" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="openModal('{{ $mediaUrl }}', '{{ $index }}')">
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="carousel-item active">
                                    <div class="ratio ratio-1x1 rounded overflow-hidden">
                                        <img src="{{ $productImageUrl }}" alt="{{ $product->name }}" class="w-100 h-100 product-detail-image" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="openModal('{{ $productImageUrl }}', '0')">
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
                    <div class="thumbs-wrap mt-3 position-relative">
                        <button type="button" class="btn btn-light btn-sm position-absolute top-50 start-0 translate-middle-y shadow js-thumbs-prev" aria-label="Scroll left">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div id="thumbsTrack" class="d-flex gap-2 flex-nowrap thumbs-scroll px-4">
                            @if($mediafiles->count() > 0)
                                @foreach($mediafiles as $index => $media)
                                    @php
                                        $mediaUrl = uploaded_image_url($media->file_path);
                                    @endphp
                                    <div class="thumb-item">
                                        <img src="{{ $mediaUrl }}" alt="thumb-{{ $index }}" class="img-thumbnail rounded js-thumb {{ $index==0 ? 'border-primary' : '' }}" data-index="{{ $index }}">
                                    </div>
                                @endforeach
                            @else
                                <div class="thumb-item">
                                    <img src="{{ $productImageUrl }}" alt="thumb-0" class="img-thumbnail rounded js-thumb border-primary" data-index="0">
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
                                            @php
                                                $mediaUrl = uploaded_image_url($media->file_path);
                                            @endphp
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <div class="ratio ratio-4x3">
                                                    <img src="{{ $mediaUrl }}" class="w-100 h-100 product-detail-image">
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="carousel-item active">
                                            <div class="ratio ratio-4x3">
                                                <img src="{{ $productImageUrl }}" class="w-100 h-100 product-detail-image">
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
                                            @php
                                                $mediaUrl = uploaded_image_url($media->file_path);
                                            @endphp
                                            <div class="thumb-item">
                                                <img src="{{ $mediaUrl }}" alt="mthumb-{{ $index }}" class="img-thumbnail rounded js-mthumb {{ $index==0 ? 'border-primary' : '' }}" data-index="{{ $index }}">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="thumb-item">
                                            <img src="{{ $productImageUrl }}" alt="mthumb-0" class="img-thumbnail rounded js-mthumb border-primary" data-index="0">
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
                <div class="detail-info product-info-card">
                    <div class="product-badges">
                        @if($category)
                            <a class="meta-chip" href="{{ route('view_product_category', ['slug' => $category->slug]) }}">{{ $category->name }}</a>
                        @endif
                        @if($product->has_price)
                            <span class="status-pill {{ $product->quantity > 0 ? 'in-stock' : 'out-stock' }}">
                                {{ $product->quantity > 0 ? 'In stock' : 'Out of stock' }}
                            </span>
                        @endif
                    </div>
                    <h1 class="product-title">{{ $product->name }}</h1>
                    <div class="product-price-block">
                        @if($product->has_price)
                            <span class="price-current">{{ $currency }} {{ number_format($product->price, 2) }}</span>
                            @if($hasSale)
                                <span class="price-old">{{ $currency }} {{ number_format($product->marked_price, 2) }}</span>
                                <span class="price-discount">{{ discount($product->id) }}% Off</span>
                            @endif
                        @else
                            <span class="price-current">Get a quote</span>
                        @endif
                    </div>

                    <div class="product-summary">
                        <p>{!! Str::words(strip_tags($product->description), 40, '...') !!}</p>
                    </div>
                    <div class="product-highlights">
                        <span class="highlight-item"><i class="fas fa-shipping-fast"></i>Fast delivery</span>
                        <span class="highlight-item"><i class="fas fa-shield-alt"></i>Warranty support</span>
                        <span class="highlight-item"><i class="fas fa-headset"></i>Expert help</span>
                    </div>
                    <div class="product-divider"></div>


                  

                                           

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
<form id="purchase-actions" action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center flex-wrap gap-3">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">

    @if($product->sizes->count() > 0)
        <div class="attr-detail attr-size size-picker">
            <span class="size-label">Size</span>
            <ul class="list-filter size-filter font-small">
                @foreach($product->sizes as $size)
                    <li>
                        <input type="radio"
                               id="size-{{ $size->id }}"
                               name="size_id"
                               value="{{ $size->id }}"
                               class="radio-custom"
                               {{ old('size', $product->sizes->first()->name) == $size->name ? 'checked' : '' }}>
                        <label for="size-{{ $size->id }}">{{ $size->name }}</label>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="w-100"></div>
    <div class="d-flex align-items-center flex-wrap gap-2 buy-actions product-actions">
        <button type="submit" class="btn btn-accent btn-lg d-inline-flex align-items-center"><i class="fas fa-shopping-cart me-2"></i><span>Buy Now</span></button>
        @if($waLink)
            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-success btn-lg d-inline-flex align-items-center"><i class="fab fa-whatsapp me-2"></i><span>WhatsApp</span></a>
        @endif
    </div>
</form>
                                @else
                                    <div class="d-flex align-items-center flex-wrap gap-2 product-actions">
                                        <button type="button" class="btn btn-accent btn-lg d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#quoteModal">Get Quote</button>
                                        @if($waLink)
                                            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-success btn-lg d-inline-flex align-items-center"><i class="fab fa-whatsapp me-2"></i><span>WhatsApp</span></a>
                                        @endif
                                    </div>
                                @endif
                            @else
                                <div class="d-flex align-items-center flex-wrap gap-2 product-actions">
                                    <button type="button" class="btn btn-accent btn-lg d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#notifyModal">Notify Me</button>
                                    @if($waLink)
                                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-success btn-lg d-inline-flex align-items-center"><i class="fab fa-whatsapp me-2"></i><span>WhatsApp</span></a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <ul class="product-meta-list">
                        @if($product->has_price)
                            <li>
                                <span>Availability:</span>
                                <span class="status-pill {{ $product->quantity > 0 ? 'in-stock' : 'out-stock' }}">{{ $product->quantity > 0 ? 'Available in store' : 'Out of stock' }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tab Section for Description -->
        <div class="tab-style3 product-description-section mt-5">
            <ul class="nav nav-tabs text-uppercase">
                <li class="nav-item">
                    <a class="nav-link active" id="Description-tab" data-bs-toggle="tab" href="#Description">Description</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="Description">
                    <div class="container">
                        <div id="product-description" class="product-description-content">
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            $ctaPhone = trim((string) get_option('contact_phone'));
            $ctaPhoneDial = preg_replace('/\D+/', '', $ctaPhone);
        @endphp
        <div class="product-cta">
            <div class="product-cta-card">
                <div class="product-cta-copy">
                    <span class="product-cta-kicker">Need help?</span>
                    <h3>Talk to an expert about {{ $product->name }}</h3>
                    <p>Get guidance on setup, compatibility, and delivery tailored to your needs.</p>
                </div>
                <div class="product-cta-actions">
                    @if($product->has_price && $product->quantity > 0)
                        <a href="#purchase-actions" class="btn btn-accent btn-lg">Buy Now</a>
                    @endif
                    <a href="{{ route('contacts') }}" class="btn btn-outline-secondary btn-lg">Get expert help</a>
                    @if($ctaPhoneDial)
                        <a href="tel:{{ $ctaPhoneDial }}" class="btn btn-outline-secondary btn-lg">Call {{ $ctaPhone }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
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
