<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>
        @section('title') 
        {{ get_option('site_name') }} 
        @show
    </title>

    <meta name="description" content="@yield('meta_description', get_option('hero_header_description'))">
    <meta name="keywords" content="@yield('meta_keywords', get_option('hero_header_description'))">

    @section('social-meta')
    {{-- canonical handled separately below to avoid duplicates --}}
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', get_option('site_name'))" />
    <meta property="og:description" content="@yield('og_description', get_option('hero_header_description'))" />
    <meta property="og:image" content="@yield('og_image', get_option('hero_image'))" />
    <meta property="og:url" content="@yield('og_url', url('/'))" />
    <meta property="og:site_name" content="{{ get_option('site_name') }}" />
    <meta property="og:type" content="@yield('og_type', 'website')" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@yield('twitter_site', url('/'))" />
    <meta name="twitter:title" content="@yield('twitter_title', get_option('site_name'))" />
    <meta name="twitter:description" content="@yield('twitter_description', get_option('hero_image'))" />
    <meta name="twitter:image" content="@yield('twitter_image', get_option('hero_image'))" />
    @show

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ get_option('favicon', asset('default-favicon.png')) }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ get_option('favicon', asset('default-favicon.png')) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ get_option('favicon', asset('default-favicon.png')) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ get_option('favicon', asset('default-favicon.png')) }}">
    <link rel="manifest" href="{{ asset('dark/assets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ get_option('favicon', asset('default-favicon.png')) }}">

    <!-- Canonical URL -->
    @php
        $canonicalBase = rtrim(config('app.url') ?: url('/'), '/');
        $canonicalPath = request()->getPathInfo();
        $canonicalUrl  = $canonicalBase . $canonicalPath;
    @endphp
    <link rel="canonical" href="@yield('canonical', $canonicalUrl)">

    <!-- Preload Critical CSS -->
    <link rel="preload" href="{{ url('/') }}/lucare/assets/css/main.css?v=3.4" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" as="style">

    <!-- Performance hints -->
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ url('/') }}/lucare/assets/css/main.css?v=3.4">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/') }}/lucare/assets/css/style.css">

    <!-- Gamun UI overrides -->
    <style>
      @include('theme.gamun.css.overrides')
    </style>

    @php
        $siteUrl   = rtrim(config('app.url') ?: url('/'), '/');
        $siteName  = get_option('site_name', 'Starlink Kenya Installers');
        $logo      = get_option('logo');
        $heroImage = get_option('hero_image') ?: $logo;
        $phone     = get_option('contact_phone');
        $address   = get_option('address');
        $sameAs    = array_values(array_filter([
            get_option('facebook'),
            get_option('twitter'),
            get_option('instagram'),
            get_option('linkedin'),
        ]));

        $org = [
            '@context' => 'https://schema.org',
            '@type'    => 'LocalBusiness',
            '@id'      => $siteUrl . '/#organization',
            'name'     => $siteName,
            'url'      => $siteUrl,
            'logo'     => $logo,
            'image'    => $heroImage,
            'telephone'=> $phone,
            'address'  => [
                '@type'         => 'PostalAddress',
                'streetAddress' => $address,
                'addressCountry'=> 'KE',
            ],
            'areaServed' => ['KE'],
            'contactPoint' => [
                [
                    '@type'         => 'ContactPoint',
                    'telephone'     => $phone,
                    'contactType'   => 'customer support',
                    'areaServed'    => 'KE',
                    'availableLanguage' => ['en'],
                ],
            ],
            'sameAs'     => $sameAs,
        ];

        $website = [
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            '@id'      => $siteUrl . '/#website',
            'url'      => $siteUrl,
            'name'     => $siteName,
            'publisher'=> ['@id' => $siteUrl . '/#organization'],
        ];
    @endphp
    <script type="application/ld+json">@json($org, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)</script>
    <script type="application/ld+json">@json($website, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)</script>

    @stack('meta')
    @yield('styles')
</head>


<body>
    <!-- Welding Service Topbar -->
    <div class="welding-topbar small text-white py-1 d-none d-md-block">
      <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
          <span class="opacity-75"><i class="fas fa-tools me-1"></i> Onsite Welding Service · Kenya-wide</span>
          <span class="d-none d-lg-inline opacity-75"><i class="fas fa-bolt me-1"></i> Same-day response</span>
          <span class="d-none d-lg-inline opacity-75"><i class="fas fa-shield-alt me-1"></i> Quality guarantee</span>
        </div>
        <div class="d-flex align-items-center gap-2">
          <a href="{{ route('contacts') }}" class="link-light text-decoration-none"><i class="fas fa-phone me-1"></i> {{ get_option('contact_phone') }}</a>
          @php
            $rawPhone = get_option('contact_phone');
            $wa = preg_replace('/\D+/', '', $rawPhone ?? '');
            if (\Illuminate\Support\Str::startsWith($wa, '0')) { $wa = '254'.\Illuminate\Support\Str::substr($wa, 1); }
            $waMsg = urlencode('Hi, I need onsite welding service.');
            $waLink = $wa ? "https://wa.me/{$wa}?text={$waMsg}" : null;
          @endphp
          @if($waLink)
            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-success btn-sm d-inline-flex align-items-center"><i class="fab fa-whatsapp me-1"></i>WhatsApp</a>
          @endif
        </div>
      </div>
    </div>

    <header class="header-area header-style-1 header-height-2">

        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                        <a href="{{ url('/')}}">
                            <img src="{{ get_option('logo') }}" alt="logo">
                        </a>
                    </div>

                    <?php 

                    $categories = \App\Models\Category::all();
                    ?>
                    <div class="header-right">
                        <div class="search-style-2">
                            <form action="{{ url('shop') }}" method="get">
                                <input type="text" name="q" placeholder="Search for items..." required>
                                <button type="submit">
                                    <i class="fi-rs-search"></i>
                                </button>
                            </form>
                        </div>



                        @php
                        $cart = session()->get('cart', []);
                        $total = 0;
                        foreach ($cart as $item) {
                            $total += $item['price'] * $item['quantity'];
                        }
                        @endphp



                        <div class="container-fluid">
                            <div class="d-flex justify-content-end align-items-center py-3">
                                <!-- Wishlist Icon -->
                                <div class="me-3">
                                    <a href="{{ route('wishlist.index') }}" class="text-dark text-decoration-none d-flex align-items-center">
                                        <img class="svgInject" alt="Evara" src="{{ url('/') }}/lucare/assets/imgs/theme/icons/icon-heart.svg" width="24" height="24">
                                        <span class="badge bg-dark ms-2">0</span>
                                    </a>
                                </div>

                                <!-- Cart Icon -->
                                <div class="me-3">
                                    <a href="{{ route('cart.view') }}" class="text-dark text-decoration-none d-flex align-items-center">
                                        <img alt="Evara" src="{{ url('/') }}/lucare/assets/imgs/theme/icons/icon-cart.svg" width="24" height="24">
                                        <span class="badge bg-dark ms-2">{{ count(Session::get('cart', [])) }}</span>
                                    </a>
                                </div>

                                <!-- Account Button -->
                                <div>
                                    <a href="{{ route('login') }}" class="btn btn-dark d-flex align-items-center px-3 py-2 rounded-pill text-white">
                                        <i class="bi bi-person-circle me-2" style="font-size: 20px;"></i> My Account
                                    </a>
                                </div>
                            </div>
                        </div>





                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="{{ url('/')}}"><img src="{{ get_option('logo') }}" alt="logo"></a>
                    </div>
                    <div class="header-nav d-none d-lg-flex">

                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block">
                            <nav>
                                <ul>
                                    @if(in_array(request()->getHost(), ['gamun.co.ke','www.gamun.co.ke']))
                                    <li><a href="{{ url('/welding-services') }}">Welding Services</a></li>
                                    <li><a href="{{ route('welding-products.index') }}">Our Products</a></li>
                                    @endif

                        @foreach(\App\Models\Menu::all() as $menu)
                        @php
                            $currentUrl = url()->current();
                            $menuUrl = \Illuminate\Support\Str::startsWith($menu->url, ['http://','https://'])
                                ? $menu->url
                                : url($menu->url);
                            $isActive = rtrim($menuUrl, '/') === rtrim($currentUrl, '/');
                        @endphp
                        <li>
                            <a href="{{ $menu->url }}" class="{{ $isActive ? 'active' : '' }}">{{ \Illuminate\Support\Str::title($menu->name) }}</a>
                        </li>
                        @endforeach




                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="d-none d-lg-flex align-items-center gap-3 ms-auto">
                        <div class="hotline"><p class="mb-0"><i class="fi-rs-headset"></i><span class="me-1">Need Help?</span> {{ get_option('contact_phone') }}</p></div>
                        <a href="{{ url('/welding-services') }}" class="btn btn-primary btn-sm rounded-pill px-3">Book Welder</a>
                    </div>

                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                <a href="{{ route('wishlist.index')}}">
                                    <img alt="Wishlist" src="{{ url('/') }}/lucare/assets/imgs/theme/icons/icon-heart.svg">
                                    <span class="pro-count white">0</span>
                                </a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="{{ route('cart.view') }}">
                                    <img alt="Cart" src="{{ url('/') }}/lucare/assets/imgs/theme/icons/icon-cart.svg">
                                    <span class="pro-count white">{{ count(Session::get('cart', [])) }}</span>
                                </a>
                                {{-- <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                    <ul>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="{{url ('shop-product')}}"><img alt="Evara" src="{{ url('/') }}/lucare/assets/imgs/shop/thumbnail-3.jpg"></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="{{url ('shop-product')}}">Plain Striola Shirts</a></h4>
                                                <h3><span>1 × </span>$800.00</h3>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="{{url ('shop-product')}}"><img alt="Evara" src="{{ url('/') }}/lucare/assets/imgs/shop/thumbnail-4.jpg"></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="{{url ('shop-product')}}">Macbook Pro 2022</a></h4>
                                                <h3><span>1 × </span>$3500.00</h3>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            <h4>Total <span>$383.00</span></h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="{{url ('shop-cart')}}">View cart</a>
                                            <a href="shop-checkout.html">Checkout</a>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="header-action-icon-2 d-block d-lg-none">
                                <div class="burger-icon burger-icon-white">
                                    <span class="burger-icon-top"></span>
                                    <span class="burger-icon-mid"></span>
                                    <span class="burger-icon-bottom"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                    <a href="{{ url('home') }}"><img src="{{ get_option('logo') }}" alt="logo"></a>
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>
            <div class="mobile-header-content-area">
                <div class="mobile-search search-style-3 mobile-header-border">
                   <form action="{{ url('shop') }}" method="get">
                    <input type="text" name="q" placeholder="Search for items...">
                    <button type="submit"><i class="fi-rs-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">

                <!-- mobile menu start -->
                <nav>
                    <ul class="mobile-menu">





                        @foreach(\App\Models\Menu::all() as $menu)
                        @php
                            $currentUrl = url()->current();
                            $menuUrl = \Illuminate\Support\Str::startsWith($menu->url, ['http://','https://']) ? $menu->url : url($menu->url);
                            $isActive = rtrim($menuUrl, '/') === rtrim($currentUrl, '/');
                        @endphp
                        <li class="menu-item-has-children">
                            <a href="{{ $menu->url }}" class="{{ $isActive ? 'active' : '' }}">{{ \Illuminate\Support\Str::title($menu->name) }}</a>
                        </li>
                        @endforeach

                        
                    </ul>
                </nav>
                <!-- mobile menu end -->
            </div>
            <div class="mobile-header-info-wrap mobile-header-border">
                <div class="single-mobile-header-info mt-30">
                    <a href="page-contact.html"> Our location </a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="{{ url('login') }}">Log In / Sign Up </a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="#">{{ get_option('contact_phone') }} </a>
                </div>
            </div>
            <div class="mobile-social-icon">
                <h5 class="mb-15 text-grey-4">Follow Us</h5>
                <a href="#"><img src="{{ url('/') }}/lucare/assets/imgs/theme/icons/icon-facebook.svg" alt=""></a>
                <a href="#"><img src="{{ url('/') }}/lucare/assets/imgs/theme/icons/icon-twitter.svg" alt=""></a>
                <a href="#"><img src="{{ url('/') }}/lucare/assets/imgs/theme/icons/icon-instagram.svg" alt=""></a>
                <a href="#"><img src="{{ url('/') }}/lucare/assets/imgs/theme/icons/icon-pinterest.svg" alt=""></a>
                <a href="#"><img src="{{ url('/') }}/lucare/assets/imgs/theme/icons/icon-youtube.svg" alt=""></a>
            </div>
        </div>
    </div>
</div>
<main class="main">


   @include('flash_msg')
