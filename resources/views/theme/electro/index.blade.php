{{-- resources/views/theme/electro/index.blade.php --}}
@extends('theme.electro.layouts.main')

@section('title', get_option('hero_header_title'))
@section('meta_description', get_option('hero_header_description'))

@section('main')

<!-- ╭──────────────────────────────╮
     │ HERO CAROUSEL (auto + video) │
     ╰──────────────────────────────╯ -->
<section class="hero-section">
    <div id="heroCarousel"
         class="carousel slide"
         data-bs-ride="carousel"
         data-bs-interval="6000"   {{-- auto-advance every 6 s --}}
         data-bs-pause="false"     {{-- ⟸ keep cycling even on hover/focus --}}
         data-bs-touch="true">

        <!-- Indicators -->
        <div class="carousel-indicators">
            @foreach($sliders as $i => $slider)
                <button type="button"
                        data-bs-target="#heroCarousel"
                        data-bs-slide-to="{{ $i }}"
                        class="{{ $i === 0 ? 'active' : '' }}"
                        aria-current="{{ $i === 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $i + 1 }}">
                </button>
            @endforeach
        </div>

        <!-- Slides -->
        <div class="carousel-inner">
            @foreach($sliders as $i => $slider)
                <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                    <div class="container">
                        <div class="row align-items-center py-4">

                            <!-- Text column -->
                            <div class="col-lg-6">
                                @if(!empty($slider->h4_title))
                                    <span class="hero-eyebrow">{{ $slider->h4_title }}</span>
                                @endif
                                <h1 class="display-5 fw-bolder mb-2 hero-title">{{ $slider->h1_title }}</h1>
                                @if(!empty($slider->h2_title))
                                    <h2 class="h4 fw-semibold mb-2 hero-subtitle">{{ $slider->h2_title }}</h2>
                                @endif
                                <p class="mb-3">{{ $slider->description }}</p>
                                <div class="hero-cta mb-2">
                                    <a class="btn btn-accent btn-lg" href="{{ $slider->button_url }}">{{ $slider->button_text }}</a>
                                    <a class="btn btn-outline-secondary btn-lg" href="{{ url('shop') }}">Shop Now</a>
                                </div>
                                <div class="hero-badges">
                                    <span class="hero-badge"><span class="icn"><i class="fas fa-shipping-fast"></i></span>Fast delivery</span>
                                    <span class="hero-badge"><span class="icn"><i class="fas fa-shield-alt"></i></span>Warranty</span>
                                    <span class="hero-badge"><span class="icn"><i class="fas fa-headset"></i></span>Support</span>
                                </div>
                            </div>

                            <!-- Media (image / local video / YouTube / Vimeo) -->
                            <div class="col-lg-6 text-center hero-media">
                                @php
                                    $src         = $slider->img_url;
                                    $isVideoFile = \Illuminate\Support\Str::endsWith($src, ['.mp4', '.webm', '.ogg']);
                                    $isYouTube   = \Illuminate\Support\Str::contains($src, ['youtube.com', 'youtu.be']);
                                    $isVimeo     = \Illuminate\Support\Str::contains($src, 'vimeo.com');
                                @endphp

                                <div class="media-frame">
                                    {{-- Local/hosted video --}}
                                    @if($isVideoFile)
                                        <video src="{{ $src }}" class="w-100" autoplay muted loop playsinline></video>

                                    {{-- YouTube embed --}}
                                    @elseif($isYouTube)
                                        @php
                                            preg_match('~(youtu\.be/|v=)([^&/]+)~', $src, $m);
                                            $ytId = $m[2] ?? '';
                                        @endphp
                                        <iframe class="w-100"
                                                src="https://www.youtube.com/embed/{{ $ytId }}?autoplay=1&mute=1&loop=1&controls=0&playlist={{ $ytId }}"
                                                frameborder="0"
                                                allow="autoplay; encrypted-media"
                                                allowfullscreen></iframe>

                                    {{-- Vimeo embed --}}
                                    @elseif($isVimeo)
                                        @php
                                            preg_match('~vimeo\.com/(?:video/)?(\d+)~', $src, $m);
                                            $vmId = $m[1] ?? '';
                                        @endphp
                                        <iframe class="w-100"
                                                src="https://player.vimeo.com/video/{{ $vmId }}?autoplay=1&muted=1&loop=1&background=1"
                                                frameborder="0"
                                                allow="autoplay; fullscreen; picture-in-picture"
                                                allowfullscreen></iframe>

                                    {{-- Fallback image --}}
                                    @else
                                        <img src="{{ $src }}" alt="Hero media" class="img-fluid" loading="lazy">
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button"
                data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button"
                data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<!-- CTA band -->
<section class="py-5">
    <div class="container">
        <div class="cta-band d-flex flex-column flex-lg-row align-items-center justify-content-between">
            <div class="mb-3 mb-lg-0">
                <h3 class="mb-1">Shop the latest electronics today</h3>
                <p>Discover deals on top brands with fast delivery and support.</p>
            </div>
            <div class="cta-actions">
                <a href="{{ url('shop') }}" class="btn btn-accent">Browse Products</a>
                <a href="{{ route('contacts') }}" class="btn btn-outline-secondary">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<!-- Feature bar: shipping, warranty, support -->
<section class="py-3">
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-3 features-bar">
            <div class="col">
                <div class="feature-item d-flex align-items-center gap-3">
                    <span class="feature-icon"><i class="fas fa-shipping-fast"></i></span>
                    <div>
                        <p class="feature-title">Fast Delivery</p>
                        <p class="feature-text">Same-day dispatch on most orders</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="feature-item d-flex align-items-center gap-3">
                    <span class="feature-icon"><i class="fas fa-shield-alt"></i></span>
                    <div>
                        <p class="feature-title">Secure Warranty</p>
                        <p class="feature-text">Official warranty on select items</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="feature-item d-flex align-items-center gap-3">
                    <span class="feature-icon"><i class="fas fa-headset"></i></span>
                    <div>
                        <p class="feature-title">Expert Support</p>
                        <p class="feature-text">We’re here to help 7 days a week</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>

<!-- ╭──────────────────────────────╮
     │ SECTION-WIDE INLINE STYLES   │
     ╰──────────────────────────────╯ -->
<style>
/* Card height helper */
.uniform-height{height:350px;display:flex;flex-direction:column;justify-content:space-between}
.product-content-wrap{flex-grow:1;display:flex;flex-direction:column;justify-content:space-between}

/* Hero arrows */
#heroCarousel .carousel-control-prev-icon,
#heroCarousel .carousel-control-next-icon{
    width:3rem;height:3rem;border-radius:50%;
    background-color:rgba(0,0,0,.55);
    background-size:1rem 1rem;
}
#heroCarousel .carousel-control-prev,
#heroCarousel .carousel-control-next{
    top:50%;transform:translateY(-50%);
    opacity:1!important;width:3.5rem;
}
/* desktop: arrows outside */
@media (min-width:992px){
    #heroCarousel .carousel-control-prev{left:-60px}
    #heroCarousel .carousel-control-next{right:-60px}
    .hero-section{overflow:visible}
}
/* mobile/tablet: arrows just inside */
@media (max-width:991.98px){
    #heroCarousel .carousel-control-prev{left:10px}
    #heroCarousel .carousel-control-next{right:10px}
}
</style>


<section class="featured position-relative py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3 categories-header">
            <h3 class="mb-0">Shop by Category</h3>
            <div class="controls">
                <button class="btn btn-outline-secondary btn-sm cat-prev" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
                <button class="btn btn-outline-secondary btn-sm cat-next" aria-label="Next"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
        <div class="categories-slider">
            @foreach($categories->take(18) as $category)
                <div class="category-slide">
                    <a href="{{ route('view_product_category', ['slug' => $category->slug]) }}" class="text-decoration-none text-dark d-block h-100">
                        <div class="card category-card border-0 shadow-sm h-100">
                            <div class="card-img-top position-relative overflow-hidden">
                                <img src="{{ $category->photo }}" loading="lazy"
                                     alt="{{ $category->name }}"
                                     class="img-fluid w-100 h-100 object-fit-cover">
                                <div class="overlay d-flex align-items-center justify-content-center">
                                    <h5 class="text-white fw-bold m-0">{{ $category->name }}</h5>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h6 class="card-title mb-0">{{ $category->name }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <!-- View All Categories Button -->
        <div class="text-center mt-4">
            <a href="{{ route('allcategories') }}" class="btn btn-primary">View All Categories</a>
        </div>
    </div>
    </section>


<!-- ╭──────────────────────────────╮
     │ FEATURED PRODUCTS GRID       │
     ╰──────────────────────────────╯ -->
<section class="product-tabs section-padding position-relative wow fadeIn animated">
    <div class="bg-square"></div>
    <div class="container">
        <div class="tab-header">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active"
                            id="nav-tab-one"
                            data-bs-toggle="tab"
                            data-bs-target="#tab-one"
                            type="button" role="tab"
                            aria-controls="tab-one"
                            aria-selected="true">
                        Featured products
                    </button>
                </li>
            </ul>
            <a href="#" class="view-more d-none d-md-flex">
                View More <i class="fi-rs-angle-double-small-right"></i>
            </a>
        </div>

        <div class="tab-content wow fadeIn animated">
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel">
                <div class="row product-grid-4">
                    @foreach($products as $ad)
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                            <div class="product-cart-wrap mb-30 h-100">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ route('product_details', $ad->slug) }}">
                                            <img class="default-img" src="{{ url('/') }}/storage/{{ $ad->photo }}" alt="{{ $ad->name }}" loading="lazy">
                                            <img class="hover-img"   src="{{ url('/') }}/storage/{{ $ad->photo }}" alt="{{ $ad->name }}" loading="lazy">
                                        </a>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    @php
                                        $hasSale = isset($ad->marked_price) && $ad->has_price && $ad->marked_price > 0 && $ad->marked_price > ($ad->price ?? 0);
                                    @endphp
                                    @if($hasSale)
                                        <span class="badge-sale">-{{ discount($ad->id) }}%</span>
                                    @endif
                                    <div class="product-category">
                                        <a href="{{ route('view_product_category', ['slug'=>category($ad->category_id)->slug]) }}">
                                            {{ category($ad->category_id)->name }}
                                        </a>
                                    </div>
                                    <h2>
                                        <a href="{{ route('product_details', $ad->slug) }}">
                                            {{ \Illuminate\Support\Str::limit($ad->name, 40) }}
                                        </a>
                                    </h2>
                                    <div class="product-price">
                                        @if($ad->has_price)<span>{{ price($ad) }}</span>@endif
                                    </div>
                                    <div class="product-action-1 show">
                                        <a aria-label="View more" class="action-btn hover-up"
                                           href="{{ route('product_details', $ad->slug) }}">
                                            <i class="fi-rs-shopping-bag-add"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div><!-- /row -->
            </div><!-- /tab-pane -->
        </div>
    </div>
</section>

<!-- ╭──────────────────────────────╮
     │ TESTIMONIALS  (auto-slide)   │
     ╰──────────────────────────────╯ -->
<section id="testimonials">
    <div class="container">
        <h2>What Our Clients Say</h2>
        <div id="testimonialsCarousel"
             class="carousel slide"
             data-bs-ride="carousel"
             data-bs-interval="5000"
             data-bs-pause="false"> {{-- keep cycling --}}

            <div class="carousel-inner">
                @foreach($testimonials->chunk(3) as $k => $chunk)
                    <div class="carousel-item {{ $k === 0 ? 'active' : '' }}">
                        <div class="row">
                            @foreach($chunk as $t)
                                <div class="col-md-4 mb-4">
                                    <div class="card p-4 h-100">
                                        <div class="card-body text-center">
                                            <blockquote class="blockquote mb-3">
                                                <p class="mb-2">“{{ $t->description }}”</p>
                                                <footer class="blockquote-footer">{{ $t->name }}</footer>
                                            </blockquote>
                                            <p class="text-warning mb-0">⭐⭐⭐⭐⭐</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button"
                    data-bs-target="#testimonialsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button"
                    data-bs-target="#testimonialsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<!-- ╭──────────────────────────────╮
     │ HOMEPAGE DESCRIPTION         │
     ╰──────────────────────────────╯ -->
<style>
/* Homepage description scroll only (no sticky) */
@media (min-width: 992px) {
  #homepage-description .description-scroll { max-height: calc(100vh - 180px); overflow: auto; padding-right: .25rem; }
}
@media (max-width: 991.98px) {
  #homepage-description .description-scroll { max-height: 50vh; overflow: auto; }
}
#homepage-description img { max-width: 100%; height: auto; }
#homepage-description table { width: 100%; }
#homepage-description iframe { max-width: 100%; }
</style>

<section id="homepage-description">
    <div class="container">
        <div class="description-scroll">
            {!! get_option('homepage_description') !!}
        </div>
    </div>
    
</section>

@endsection
@section('scripts')
<script>
  (function($){
    $(function(){
      var $slider = $('.categories-slider');
      if ($slider.length && $.fn.slick) {
        $slider.slick({
          slidesToShow: 4,
          slidesToScroll: 1,
          arrows: false,
          adaptiveHeight: false,
          swipeToSlide: true,
          touchThreshold: 10,
          dots: false,
          autoplay: true,
          autoplaySpeed: 3000,
          pauseOnHover: true,
          pauseOnFocus: false,
          responsive: [
            { breakpoint: 1400, settings: { slidesToShow: 4 } },
            { breakpoint: 1200, settings: { slidesToShow: 4 } },
            { breakpoint: 992,  settings: { slidesToShow: 4 } },
            { breakpoint: 768,  settings: { slidesToShow: 3 } },
            { breakpoint: 576,  settings: { slidesToShow: 2 } },
            { breakpoint: 0,    settings: { slidesToShow: 1 } }
          ]
        });
      }
    });
  })(jQuery);
</script>
<script>
  (function($){
    $(function(){
      var $section = $('.featured');
      var $slider = $section.find('.categories-slider');
      var $header = $section.find('.categories-header');
      if ($slider.length && $.fn.slick) {
        $header.find('.cat-prev').off('click.slick').on('click.slick', function(){ $slider.slick('slickPrev'); });
        $header.find('.cat-next').off('click.slick').on('click.slick', function(){ $slider.slick('slickNext'); });
      }
    });
  })(jQuery);
</script>
<script>
  // Removed sticky pass-through: default page scroll behavior restored
</script>
@endsection





