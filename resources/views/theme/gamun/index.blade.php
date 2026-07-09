@extends('theme.gamun.layouts.main')
@section('title') {{ get_option('hero_header_title') }} @endsection
@section('meta_description', get_option('hero_header_description'))
@section('main')

@php
    $rawPhone = get_option('contact_phone');
    $wa = preg_replace('/\D+/', '', $rawPhone ?? '');
    if (\Illuminate\Support\Str::startsWith($wa, '0')) { $wa = '254'.\Illuminate\Support\Str::substr($wa, 1); }
    $waMessage = urlencode("Hi, I'd like to book an onsite welding service.");
    $waLink = $wa ? "https://wa.me/{$wa}?text={$waMessage}" : null;
    $heroImg = get_option('hero_image') ?: get_option('logo');
@endphp

<!-- Welding Service Hero -->
<section class="welding-hero py-5 py-lg-6">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-7">
        <div class="hero-copy">
          <span class="badge rounded-pill bg-primary mb-3">Onsite Welding Service</span>
          <h1 class="display-5 fw-bold mb-3">Professional Mobile Welding Across Kenya</h1>
          <p class="lead text-secondary mb-4">Repairs, fabrication and installations done right — fast response, skilled welders, quality guaranteed.</p>
          <div class="d-flex flex-wrap gap-2 mb-4">
            <a href="{{ route('contacts') }}" class="btn btn-primary btn-lg rounded-pill px-4"><i class="fas fa-calendar-check me-2"></i>Book a Welder</a>
            @if($waLink)
            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-success btn-lg rounded-pill px-4 d-inline-flex align-items-center"><i class="fab fa-whatsapp me-2"></i>WhatsApp Us</a>
            @endif
          </div>
          <ul class="list-unstyled d-flex flex-wrap gap-3 text-muted mb-0">
            <li class="d-flex align-items-center"><i class="fas fa-bolt text-primary me-2"></i>Same-day response</li>
            <li class="d-flex align-items-center"><i class="fas fa-user-check text-primary me-2"></i>Certified welders</li>
            <li class="d-flex align-items-center"><i class="fas fa-shield-alt text-primary me-2"></i>Guaranteed workmanship</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="hero-media shadow-sm">
          <div class="ratio ratio-4x3 rounded" style="background:url('{{ $heroImg }}') center/cover no-repeat"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- How It Works -->
<section class="how-it-works section-padding pt-3 pb-4">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="h3 fw-bold mb-2">How It Works</h2>
      <p class="text-muted mb-0">Quick and simple process to get a welder onsite</p>
    </div>
    <div class="row g-3 g-lg-4">
      <div class="col-12 col-md-4">
        <div class="how-card h-100 p-3 p-lg-4">
          <div class="icon-wrap bg-primary-subtle text-primary"><i class="fas fa-phone-alt"></i></div>
          <h3 class="h5 mt-2">1) Request</h3>
          <p class="mb-0 text-muted">Call, WhatsApp or book online. Tell us what you need welded or fabricated.</p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="how-card h-100 p-3 p-lg-4">
          <div class="icon-wrap bg-primary-subtle text-primary"><i class="fas fa-clipboard-check"></i></div>
          <h3 class="h5 mt-2">2) Assess & Quote</h3>
          <p class="mb-0 text-muted">We confirm scope, share a quote and schedule the visit — same‑day where possible.</p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="how-card h-100 p-3 p-lg-4">
          <div class="icon-wrap bg-primary-subtle text-primary"><i class="fas fa-wrench"></i></div>
          <h3 class="h5 mt-2">3) Onsite Welding</h3>
          <p class="mb-0 text-muted">A certified welder completes the work onsite. We test, clean up and handover.</p>
        </div>
      </div>
    </div>
  </div>
  </section>

<!-- Service Areas -->
<section class="service-areas section-padding pt-0 pb-4">
  <div class="container">
    <div class="row align-items-center g-3">
      <div class="col-lg-4">
        <h2 class="h4 fw-bold mb-2">Service Areas</h2>
        <p class="text-muted mb-0">We cover Kenya‑wide with rapid response in major towns.</p>
      </div>
      <div class="col-lg-8">
        <div class="areas-wrap d-flex flex-wrap gap-2">
          @php($areas = ['Nairobi','Kiambu','Thika','Ruiru','Nakuru','Naivasha','Mombasa','Eldoret','Kisumu','Meru','Nyeri','Machakos'])
          @foreach($areas as $a)
            <span class="badge rounded-pill bg-light text-dark border">{{ $a }}</span>
          @endforeach
          <span class="badge rounded-pill bg-primary">Kenya‑wide</span>
        </div>
      </div>
    </div>
  </div>
</section>

@if(isset($medias) && $medias->count() > 0)
<!-- Welding Portfolio (horizontal strip) -->
<section class="portfolio-strip section-padding pt-0 pb-4">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between mb-2">
      <h2 class="h5 mb-0">Welding Portfolio</h2>
      <a href="#medias" class="btn btn-sm btn-outline-primary">View Gallery</a>
    </div>
    <div class="position-relative">
      <button type="button" class="btn btn-light btn-sm position-absolute top-50 start-0 translate-middle-y shadow js-port-prev" aria-label="Scroll left">
        <i class="fas fa-chevron-left"></i>
      </button>
      <div id="portfolioTrack" class="d-flex gap-3 flex-nowrap portfolio-scroll px-4">
        @foreach($medias->take(12) as $media)
          <div class="port-item">
            <img src="{{ $media->file_path }}" alt="Welding work" loading="lazy" decoding="async">
          </div>
        @endforeach
      </div>
      <button type="button" class="btn btn-light btn-sm position-absolute top-50 end-0 translate-middle-y shadow js-port-next" aria-label="Scroll right">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>
  </div>
</section>
@endif

 <section class="home-slider position-relative pt-50">
            <div class="hero-slider-1 dot-style-1 dot-style-1-position-1">
@foreach($sliders as $slider)
                <div class="single-hero-slider single-animation-wrap">
                    <div class="container">
                        <div class="row align-items-center slider-animated-1">
                            <div class="col-lg-5 col-md-6">
                                <div class="hero-slider-content-2">
                                    <h4 class="animated">{{ $slider->h4_title }}</h4>
                                    <h2 class="animated fw-900">{{ $slider->h2_title }}</h2>
                                    <h1 class="animated fw-900 text-brand">{{ $slider->h1_title }}</h1>
                                    <p class="animated">{{ $slider->description }}</p>
                                    <a class="animated btn btn-brush btn-brush-3" href="{{ $slider->button_url }}"> {{ $slider->button_text }} </a>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-6">
                                <div class="single-slider-img single-slider-img-1">
                                    <img class="animated slider-1-1" src="{{ $slider->img_url }}" alt="{{ $slider->h1_title ?? 'Hero slide' }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}" fetchpriority="{{ $loop->first ? 'high' : 'auto' }}" decoding="async">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

@endforeach
               
            </div>
            <div class="slider-arrow hero-slider-1-arrow"></div>
        </section>


<section class="featured position-relative py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h3 class="h5 mb-0">Shop by Category</h3>
            <a href="{{ route('allcategories') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>

        <div class="position-relative">
            <button type="button" class="btn btn-light btn-sm position-absolute top-50 start-0 translate-middle-y shadow js-cat-prev" aria-label="Scroll left">
                <i class="fas fa-chevron-left"></i>
            </button>

            <div id="catTrack" class="d-flex gap-3 flex-nowrap cat-scroll px-4">
                @foreach($categories->take(18) as $category)
                    <a href="{{ route('view_product_category', ['slug' => $category->slug]) }}" class="cat-item text-decoration-none text-dark">
                        <div class="cat-card border-0 shadow-sm">
                            <div class="cat-thumb">
                                <img src="{{ $category->photo }}" alt="{{ $category->name }}" loading="lazy" decoding="async">
                                <div class="cat-overlay"><span>{{ $category->name }}</span></div>
                            </div>
                            <div class="cat-title text-center">{{ $category->name }}</div>
                        </div>
                    </a>
                @endforeach
            </div>

            <button type="button" class="btn btn-light btn-sm position-absolute top-50 end-0 translate-middle-y shadow js-cat-next" aria-label="Scroll right">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>



        <section class="product-tabs section-padding position-relative wow fadeIn animated">
            <div class="bg-square"></div>
            <div class="container">
                <div class="tab-header">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">

                        <li class="nav-item" role="presentation">

<button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one" type="button" role="tab" aria-controls="tab-one" aria-selected="true">  {{ get_option('products_section_title', 'Our Stationery Collection') }}
</button>

                        </li>
                 
                    </ul>
                    <a href="{{ url('shop') }}" class="view-more d-none d-md-flex">View More<i class="fi-rs-angle-double-small-right"></i></a>
                </div>
        <!--End nav-tabs-->
        <div class="tab-content wow fadeIn animated" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                <div class="row product-grid-4">


       @foreach($products as $ad)

                                     <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                        <div class="product-cart-wrap mb-30 uniform-height">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                    <a href="{{ route('product_details', $ad->slug) }}">
                                        <img class="default-img" src="{{ url('/') }}/storage/{{ $ad->photo }}" alt="{{ $ad->name }}" loading="lazy" decoding="async">
                                        <img class="hover-img" src="{{ url('/') }}/storage/{{ $ad->photo }}" alt="{{ $ad->name }}" loading="lazy" decoding="async">
                                    </a>
                                </div>
                            </div>
                            <div class="product-content-wrap">
                                <div class="product-category">
                                    <a href="{{ route('view_product_category', ['slug' => category($ad->category_id)->slug]) }}">{{ category($ad->category_id)->name }}</a>
                                </div>
                                <h2><a href="{{ route('product_details', $ad->slug) }}">{{ \Illuminate\Support\Str::limit($ad->name, 40) }}</a></h2>
                                <div class="product-price">
                                    @if($ad->has_price)
                                    <span>{{ price($ad) }} </span>
                                    @endif
                                </div>
                                <div class="product-action-1 show">
                                    <a aria-label="View more" class="action-btn hover-up" href="{{ route('product_details', $ad->slug) }}"><i class="fi-rs-shopping-bag-add"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
       @endforeach

                        </div>
                        <!--End product-grid-4-->
                    </div>
                    <!--En tab one (Featured)-->

    
                    <!--En tab three (New added)-->
                </div>
                <!--End tab-content-->

                   <!-- View All Products Button -->
        <div class="text-center mt-4">
            <a href="/shop" class="btn btn-dark btn-lg rounded-pill px-4">
                View All Products
            </a>
        </div>
            </div>
        </section>





<!-- Services Section -->

@if($medias2->count()>0)
<section class="bg-light py-5" id="medias">
    <div class="container">
  

        <!-- Carousel -->
        <div id="mediaCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @foreach($medias2->chunk(4) as $key => $mediaChunk)
                    <div class="carousel-item @if($key == 0) active @endif">
                        <div class="row">
                            @foreach($mediaChunk as $media)
                                <div class="col-md-3">
                                    <div class="media-card2" data-bs-toggle="modal" data-bs-target="#imageModal1" onclick="showImagea('{{ $media->file_path }}')">
                                        <img class="d-block w-100" src="{{ $media->file_path }}" alt="Installation" loading="lazy" decoding="async">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#mediaCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mediaCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
@endif
<!-- Modal -->
<div class="modal fade" id="imageModal1" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Full View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage2" src="" alt="Full View" class="img-fluid">
            </div>
        </div>
    </div>
</div>


<!-- JavaScript -->
<script>
    function showImagea(imagePath) {
        const modalImage = document.getElementById('modalImage2');
        modalImage.src = imagePath;
    }
</script>

<section class="py-5 bg-light" id="testimonials">
    <div class="container">
        <h2 class="text-center mb-5">What Our Clients Say</h2>

        <!-- Testimonials Carousel -->
        <div id="testimonialsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @foreach($testimonials->chunk(3) as $key => $testimonialChunk)
                    <div class="carousel-item @if($key == 0) active @endif">
                        <div class="row">
                            @foreach($testimonialChunk as $testimonial)
                                <div class="col-md-4">
                                    <div class="card shadow-sm border-light h-100 rounded-lg p-3">
                                        <div class="card-body text-center">
                                            <blockquote class="blockquote mb-0">
                                                <p class="font-italic">"{{ $testimonial->description }}"</p>
                                                <footer class="blockquote-footer mt-3">{{ $testimonial->name }}</footer>
                                            </blockquote>
                                            <p class="text-warning mt-2">⭐⭐⭐⭐⭐</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<!-- Homepage enhancements styles -->
<style>
  /* Welding hero */
  .welding-hero { background: linear-gradient(180deg, #ffffff, #f8f9fb); }
  .welding-hero .hero-copy h1 { letter-spacing: .2px; }
  .welding-hero .hero-media .ratio { box-shadow: 0 10px 30px rgba(0,0,0,.08); }
  /* How it works */
  .how-card { background:#fff; border:1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow-sm); }
  .how-card .icon-wrap { width:40px; height:40px; display:inline-flex; align-items:center; justify-content:center; border-radius: 10px; }
  /* Service areas */
  .areas-wrap .badge { padding:.55rem .8rem; }
  /* Portfolio strip */
  .portfolio-scroll { overflow-x:auto; -webkit-overflow-scrolling:touch; scroll-snap-type:x mandatory; }
  .port-item { scroll-snap-align:start; flex:0 0 auto; width:220px; }
  .port-item img { width:100%; height:160px; object-fit:cover; border-radius: var(--radius); box-shadow: var(--shadow-sm); }
  @media (max-width: 576px) { .port-item { width: 180px; } .port-item img { height: 130px; } }
  /* Categories horizontal scroller */
  .cat-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; scroll-snap-type: x mandatory; }
  .cat-scroll::-webkit-scrollbar { height: 8px; }
  .cat-scroll::-webkit-scrollbar-thumb { background: rgba(0,0,0,.15); border-radius: 4px; }
  .cat-item { scroll-snap-align: start; flex: 0 0 auto; width: 180px; }
  .cat-card { background: #fff; border-radius: .75rem; overflow: hidden; }
  .cat-thumb { position: relative; aspect-ratio: 1/1; overflow: hidden; }
  .cat-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .3s ease; }
  .cat-overlay { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; background: linear-gradient(to top, rgba(0,0,0,.35), rgba(0,0,0,0)); color:#fff; opacity:.85; padding:.5rem; text-align:center; font-weight:600; }
  .cat-card:hover .cat-thumb img { transform: scale(1.06); }
  .cat-title { padding:.5rem .75rem; font-weight:600; font-size:.95rem; }
  @media (max-width: 576px) { .cat-item { width: 140px; } .cat-title { font-size:.9rem; } }

  /* Product grid tweaks for consistent heights */
  .uniform-height .product-img img { height: 220px !important; width: 100%; object-fit: cover; }
  @media (max-width: 576px) { .uniform-height .product-img img { height: 180px !important; } }
  .product-content-wrap h2 a { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }

  /* Media gallery height responsive */
  .media-card img { height: 360px; }
  @media (max-width: 991.98px) { .media-card img { height: 220px; } }
</style>

<!-- Homepage enhancements scripts -->
<script>
  (function(){
    // Category scroller controls
    var cPrev = document.querySelector('.js-cat-prev');
    var cNext = document.querySelector('.js-cat-next');
    var cTrack = document.getElementById('catTrack');
    function cScroll(el, dir){ if (!el) return; el.scrollBy({ left: dir * (el.clientWidth * 0.9), behavior: 'smooth' }); }
    function cUpdate(track, prev, next){
      if (!track || !prev || !next) return;
      var can = track.scrollWidth > track.clientWidth + 4;
      prev.classList.toggle('d-none', !can);
      next.classList.toggle('d-none', !can);
      if (!can) return;
      prev.disabled = track.scrollLeft <= 4;
      next.disabled = (track.scrollLeft + track.clientWidth) >= (track.scrollWidth - 4);
    }
    if (cPrev && cTrack) cPrev.addEventListener('click', function(){ cScroll(cTrack, -1); });
    if (cNext && cTrack) cNext.addEventListener('click', function(){ cScroll(cTrack, 1); });
    if (cTrack && cPrev && cNext) {
      cTrack.addEventListener('scroll', function(){ cUpdate(cTrack, cPrev, cNext); }, { passive: true });
      window.addEventListener('resize', function(){ cUpdate(cTrack, cPrev, cNext); });
      cUpdate(cTrack, cPrev, cNext);
    }

    // Portfolio scroller controls
    var pPrev = document.querySelector('.js-port-prev');
    var pNext = document.querySelector('.js-port-next');
    var pTrack = document.getElementById('portfolioTrack');
    function pScroll(el, dir){ if (!el) return; el.scrollBy({ left: dir * (el.clientWidth * 0.9), behavior: 'smooth' }); }
    function pUpdate(track, prev, next){
      if (!track || !prev || !next) return;
      var can = track.scrollWidth > track.clientWidth + 4;
      prev.classList.toggle('d-none', !can);
      next.classList.toggle('d-none', !can);
      if (!can) return;
      prev.disabled = track.scrollLeft <= 4;
      next.disabled = (track.scrollLeft + track.clientWidth) >= (track.scrollWidth - 4);
    }
    if (pPrev && pTrack) pPrev.addEventListener('click', function(){ pScroll(pTrack, -1); });
    if (pNext && pTrack) pNext.addEventListener('click', function(){ pScroll(pTrack, 1); });
    if (pTrack && pPrev && pNext) {
      pTrack.addEventListener('scroll', function(){ pUpdate(pTrack, pPrev, pNext); }, { passive: true });
      window.addEventListener('resize', function(){ pUpdate(pTrack, pPrev, pNext); });
      pUpdate(pTrack, pPrev, pNext);
    }
  })();
</script>



<!-- Store Information Section -->
<section class="bg-light py-8 pt-0" id="store">
    <div class="container-lg">
        <div class="row flex-center">
            <div class="col-sm-12 col-md-12 text-center">
                <h2 class="text-dark mb-4">{{ get_option('why_choose_title', 'Why Choose Pepasa Stationers?') }}</h2>
                <p class="text-dark mb-4">
                    {{ get_option('why_choose_description', 'At Pepasa Stationers, we offer a wide range of high-quality stationery products for individuals, businesses, and educational institutions.') }}
                </p>
            </div>
        </div>
    </div>
</section>




@if($medias->count()>0)
<!-- Services Section -->
<section class="bg-light py-5" id="medias">
    <div class="container">
        <h2 class="text-center mb-5">Our Recent Installations</h2>

        <!-- Carousel -->
        <div id="mediaCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @foreach($medias->chunk(4) as $key => $mediaChunk)
                    <div class="carousel-item @if($key == 0) active @endif">
                        <div class="row">
                            @foreach($mediaChunk as $media)
                                <div class="col-md-3">
                                    <div class="media-card" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('{{ $media->file_path }}')">
                                        <img class="d-block w-100" src="{{ $media->file_path }}" alt="Installation">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#mediaCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mediaCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
@endif

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Full View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Full View" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- CSS for hover and enlarge effect -->
<style>
    .media-card {
        overflow: hidden;
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .media-card img {
        transition: transform 0.3s ease;
        object-fit: cover;
        height: 360px;
    }

    .media-card2 img {
        transition: transform 0.3s ease;
        object-fit: cover;
        height: 260px;
    }

    @media (max-width: 991.98px) {
        .media-card img { height: 220px; }
        .media-card2 img { height: 200px; }
    }

    .media-card:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    .media-card:hover img {
        transform: scale(1.1);
    }
</style>

<!-- JavaScript -->
<script>
    function showImage(imagePath) {
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imagePath;
    }
</script>







<!-- Services Section -->
<section class="bg-light py-5" id="services">
    <div class="container">
        <h2 class="text-center mb-5">Our Services</h2>
        <div class="row">

@foreach($services as $service)

            <!-- Sell Starlink Kits -->
            <div class="col-sm-6 col-md-4 mb-4">
                <div class="card shadow-sm border-light text-center h-100 rounded-lg">
                    <div class="card-body">
                        <h4 class="card-title text-dark">{{ $service->name }}</h4>
                        <p class="card-text">{!! $service->meta_description !!}</p>


                          <a href="{{ route('service_single', ['slug' =>$service->slug ?? '0' ]) }}">View more</a>


                    </div>
                </div>
            </div>



            @endforeach

  
        </div>
    </div>
</section>

<!-- Homepage Description Section -->
  <!--=== Homepage Description ===-->
<section id="homepage-description" class="section-py bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 position-relative">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-5 description-frame sticky-description" id="scrollable-description">
                        {!! get_option('homepage_description') !!}
                    </div>
                </div>
                <!-- Gradient fade -->
                <div class="scroll-fade"></div>
                <!-- Clickable arrow -->
                <div class="scroll-arrow text-center" id="scroll-arrow">
                    <i class="bi bi-chevron-double-down"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .description-frame {
        max-height: 500px;
        overflow-y: auto;
        border-radius: 16px;
        border: 1px solid #eaeaea;
        background: #fff;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
        padding: 2rem;
        scroll-behavior: smooth;
        position: relative;
    }

    .sticky-description {
        position: sticky;
        top: 100px;
    }

    .scroll-fade {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 60px;
        background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, #ffffff 100%);
        border-radius: 0 0 16px 16px;
        pointer-events: none;
        z-index: 10;
    }

    .scroll-arrow {
        position: absolute;
        bottom: 15px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 1.5rem;
        color: #003366;
        cursor: pointer;
        animation: bounce 2s infinite;
        z-index: 20;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {transform: translate(-50%, 0);}
        40% {transform: translate(-50%, -8px);}
        60% {transform: translate(-50%, -4px);}
    }

    .description-frame::-webkit-scrollbar {
        width: 8px;
    }

    .description-frame::-webkit-scrollbar-thumb {
        background: #003366;
        border-radius: 4px;
    }

    @media (max-width: 768px) {
        .description-frame {
            max-height: 400px;
            padding: 1.5rem;
        }

        .sticky-description {
            top: 60px;
        }

        .scroll-arrow {
            font-size: 1.2rem;
            bottom: 10px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const scrollArrow = document.getElementById('scroll-arrow');
        const scrollableContent = document.getElementById('scrollable-description');

        scrollArrow.addEventListener('click', function () {
            scrollableContent.scrollBy({
                top: 200, // scrolls 200px down
                behavior: 'smooth'
            });
        });
    });
</script>

<style type="text/css">
    #homepage-description {
    overflow: hidden; /* Prevent content from overflowing the container */
    word-wrap: break-word; /* Handle long words or links */
    max-width: 100%; /* Ensure content does not exceed the container width */
    padding: 1rem; /* Add padding for better readability */
    box-sizing: border-box; /* Include padding and borders in width/height calculations */
}

#homepage-description .container {
    margin: 0 auto; /* Center the content horizontally */
    max-width: 1200px; /* Restrict the maximum width for better readability */
}

@media (max-width: 768px) {
    #homepage-description .container {
        padding: 0 1rem; /* Add padding for smaller screens */
    }
}

</style>

@endsection
