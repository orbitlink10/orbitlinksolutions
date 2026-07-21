{{-- resources/views/theme/orbit/index.blade.php --}}
@extends('theme.orbit.layouts.main')

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
                                    $rawSrc = trim((string) $slider->img_url);
                                    $mediaPath = parse_url($rawSrc, PHP_URL_PATH) ?: $rawSrc;
                                    $isVideoFile = \Illuminate\Support\Str::endsWith($mediaPath, ['.mp4', '.webm', '.ogg']);
                                    $isYouTube = \Illuminate\Support\Str::contains($rawSrc, ['youtube.com', 'youtu.be']);
                                    $isVimeo = \Illuminate\Support\Str::contains($rawSrc, 'vimeo.com');
                                    $mediaSrc = ($isYouTube || $isVimeo) ? $rawSrc : uploaded_image_url($rawSrc);
                                @endphp

                                <div class="media-frame">
                                    {{-- Local/hosted video --}}
                                    @if($isVideoFile)
                                        <video src="{{ $mediaSrc }}" class="w-100" autoplay muted loop playsinline></video>

                                    {{-- YouTube embed --}}
                                    @elseif($isYouTube)
                                        @php
                                            preg_match('~(youtu\.be/|v=)([^&/]+)~', $rawSrc, $m);
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
                                            preg_match('~vimeo\.com/(?:video/)?(\d+)~', $rawSrc, $m);
                                            $vmId = $m[1] ?? '';
                                        @endphp
                                        <iframe class="w-100"
                                                src="https://player.vimeo.com/video/{{ $vmId }}?autoplay=1&muted=1&loop=1&background=1"
                                                frameborder="0"
                                                allow="autoplay; fullscreen; picture-in-picture"
                                                allowfullscreen></iframe>

                                    {{-- Fallback image --}}
                                    @else
                                        <img src="{{ $mediaSrc }}" alt="Hero media" class="img-fluid" loading="lazy">
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

<!-- Trust stats strip -->
<section class="trust-stats">
    <div class="container">
        <div class="trust-stats-card">
            <div class="row g-3">
                <div class="col-6 col-lg-3">
                    <div class="trust-stat">
                        <span class="stat-icon"><i class="fas fa-award"></i></span>
                        <div class="stat-text">
                            <div class="stat-value">8+ Years</div>
                            <div class="stat-label">Trusted experience</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="trust-stat">
                        <span class="stat-icon"><i class="fas fa-users"></i></span>
                        <div class="stat-text">
                            <div class="stat-value">5,000+</div>
                            <div class="stat-label">Happy customers</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="trust-stat">
                        <span class="stat-icon"><i class="fas fa-shipping-fast"></i></span>
                        <div class="stat-text">
                            <div class="stat-value">Same-day</div>
                            <div class="stat-label">Dispatch on most orders</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="trust-stat">
                        <span class="stat-icon"><i class="fas fa-shield-alt"></i></span>
                        <div class="stat-text">
                            <div class="stat-value">12-Month</div>
                            <div class="stat-label">Warranty support</div>
                        </div>
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
.homepage-products-section .homepage-product-row + .homepage-product-row{margin-top:34px}
.homepage-product-row-header{display:flex;align-items:flex-end;justify-content:space-between;gap:16px;margin-bottom:16px}
.homepage-product-row-header h3{font-size:1.2rem;font-weight:700;margin:0;color:#0b1220}
.homepage-product-row-header span{display:block;margin-top:4px;color:#667085;font-size:.9rem}
.homepage-product-row-actions{display:flex;align-items:center;gap:12px}
.homepage-product-controls{display:flex;gap:6px}
.category-product-slider:not(.slick-initialized){display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:20px}
.category-product-slide{padding:0 10px;height:auto}
.category-product-slide .product-cart-wrap{height:100%}
@media (max-width:991.98px){
    .category-product-slider:not(.slick-initialized){grid-template-columns:repeat(3,minmax(0,1fr))}
}
@media (max-width:767.98px){
    .homepage-product-row-header{align-items:flex-start;flex-direction:column}
    .homepage-product-row-actions{width:100%;justify-content:space-between}
    .category-product-slider:not(.slick-initialized){grid-template-columns:repeat(2,minmax(0,1fr))}
}
@media (max-width:575.98px){
    .category-product-slider:not(.slick-initialized){grid-template-columns:1fr}
}

/* Hero arrows */
#heroCarousel .carousel-control-prev-icon,
#heroCarousel .carousel-control-next-icon{
    width:3rem;height:3rem;border-radius:50%;
    background-color:rgba(11,18,32,.65);
    border:1px solid rgba(255,255,255,.35);
    box-shadow:var(--shadow-sm);
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


<section class="featured homepage-categories position-relative">
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
                                <img src="{{ uploaded_image_url($category->photo) }}" loading="lazy"
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
@php
    $homepageRows = collect($homepageProductCategories ?? []);

    if ($homepageRows->isEmpty() && isset($products) && $products->count()) {
        $homepageRows = collect([
            (object) [
                'name' => 'Featured products',
                'slug' => null,
                'homepageProducts' => $products,
            ],
        ]);
    }
@endphp

@if($homepageRows->isNotEmpty())
<section class="product-tabs homepage-products-section section-padding position-relative wow fadeIn animated">
    <div class="bg-square"></div>
    <div class="container">
        <div class="tab-header featured-header">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active"
                            id="nav-tab-one"
                            data-bs-toggle="tab"
                            data-bs-target="#tab-one"
                            type="button" role="tab"
                            aria-controls="tab-one"
                            aria-selected="true">
                        {{ get_option('products_section_title', 'Featured products') }}
                    </button>
                </li>
            </ul>
            <a href="{{ url('shop') }}" class="view-more d-none d-md-flex">
                View All Products <i class="fi-rs-angle-double-small-right"></i>
            </a>
        </div>

        <div class="tab-content wow fadeIn animated">
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel">
                @foreach($homepageRows as $homepageCategory)
                    @php
                        $rowProducts = collect($homepageCategory->homepageProducts ?? []);
                        $categoryUrl = !empty($homepageCategory->slug)
                            ? route('view_product_category', ['slug' => $homepageCategory->slug])
                            : url('shop');
                    @endphp

                    @if($rowProducts->isNotEmpty())
                        <div class="homepage-product-row">
                            <div class="homepage-product-row-header">
                                <div>
                                    <h3>{{ $homepageCategory->name }}</h3>
                                    <span>{{ $rowProducts->count() }} {{ \Illuminate\Support\Str::plural('product', $rowProducts->count()) }}</span>
                                </div>
                                <div class="homepage-product-row-actions">
                                    <a href="{{ $categoryUrl }}" class="view-more">
                                        View All <i class="fi-rs-angle-double-small-right"></i>
                                    </a>
                                    <div class="controls homepage-product-controls">
                                        <button class="btn btn-outline-secondary btn-sm product-row-prev" aria-label="Previous {{ $homepageCategory->name }} products">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm product-row-next" aria-label="Next {{ $homepageCategory->name }} products">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="category-product-slider">
                                @foreach($rowProducts as $ad)
                                    @php
                                        $hasSale = isset($ad->marked_price) && $ad->has_price && $ad->marked_price > 0 && $ad->marked_price > ($ad->price ?? 0);
                                        $productCategory = $ad->category ?: category($ad->category_id);
                                    @endphp
                                    <div class="category-product-slide">
                                        <div class="product-cart-wrap mb-30 h-100">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="{{ route('product_details', $ad->slug) }}">
                                                        <img class="default-img" src="{{ product_image_url($ad) }}" alt="{{ $ad->name }}" loading="lazy">
                                                        <img class="hover-img" src="{{ product_image_url($ad) }}" alt="{{ $ad->name }}" loading="lazy">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                @if($hasSale)
                                                    <span class="badge-sale">-{{ discount($ad->id) }}%</span>
                                                @endif
                                                @if($productCategory)
                                                    <div class="product-category">
                                                        <a href="{{ route('view_product_category', ['slug' => $productCategory->slug]) }}">
                                                            {{ $productCategory->name }}
                                                        </a>
                                                    </div>
                                                @endif
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
                                                        <i class="fas fa-shopping-bag"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div><!-- /tab-pane -->
        </div>
    </div>
</section>
@endif

<!-- ╭──────────────────────────────╮
     ╰──────────────────────────────╯ -->

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

<section class="prefooter-cta">
    <div class="container">
        <div class="cta-wrap">
            <div class="cta-copy">
                <span class="cta-kicker">Get started</span>
                <h2>Ready to upgrade your network?</h2>
                <p>Shop verified equipment or talk to our team for tailored recommendations.</p>
            </div>
            <div class="cta-actions">
                <a href="{{ url('shop') }}" class="btn btn-accent btn-lg">Shop Products</a>
                <a href="{{ route('contacts') }}" class="btn btn-outline-secondary btn-lg">Talk to Us</a>
            </div>
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
          slidesToShow: 6,
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
            { breakpoint: 1400, settings: { slidesToShow: 6 } },
            { breakpoint: 1200, settings: { slidesToShow: 5 } },
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
      $('.category-product-slider').each(function(){
        var $slider = $(this);
        if ($slider.hasClass('slick-initialized')) {
          return;
        }
        var slideCount = $slider.children().length;
        var $controls = $slider.closest('.homepage-product-row').find('.homepage-product-controls');

        if (slideCount <= 4 || !$.fn.slick) {
          $controls.addClass('d-none');
          return;
        }

        $slider.slick({
          slidesToShow: 4,
          slidesToScroll: 1,
          arrows: false,
          infinite: slideCount > 4,
          autoplay: true,
          autoplaySpeed: 4000,
          pauseOnHover: true,
          pauseOnFocus: false,
          swipeToSlide: true,
          touchThreshold: 10,
          responsive: [
            { breakpoint: 1400, settings: { slidesToShow: 4 } },
            { breakpoint: 1200, settings: { slidesToShow: 4 } },
            { breakpoint: 992,  settings: { slidesToShow: 3 } },
            { breakpoint: 768,  settings: { slidesToShow: 2 } },
            { breakpoint: 576,  settings: { slidesToShow: 2 } },
            { breakpoint: 0,    settings: { slidesToShow: 1 } }
          ]
        });

        $controls.find('.product-row-prev').off('click.slick').on('click.slick', function(){
          $slider.slick('slickPrev');
        });
        $controls.find('.product-row-next').off('click.slick').on('click.slick', function(){
          $slider.slick('slickNext');
        });
      });
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
