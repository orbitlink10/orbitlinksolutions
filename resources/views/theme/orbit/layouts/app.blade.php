<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    {{-- Title & SEO --}}
    @php
        $siteName = get_option('site_name', 'Orbitlink Solutions');
        $siteDesc = trim(strip_tags((string) get_option('contact_description')));
        if ($siteDesc === '') {
            $siteDesc = 'Reliable networking, Starlink, CCTV, WiFi, and ICT products in Kenya.';
        }
        $siteUrl = url('/');
        $rawLogo = get_option('logo');
        $rawFavicon = get_option('favicon');
        $rawHero = get_option('hero_image');
        $defaultLogo = asset('assets/images/orbitlinks-logo.webp');
        $absoluteUrl = function ($value) {
            if (empty($value)) {
                return null;
            }

            return \Illuminate\Support\Str::startsWith($value, ['http://', 'https://', '//'])
                ? $value
                : url($value);
        };
        $faviconUrl = uploaded_image_url($rawFavicon, asset('favicon.ico'));
        $siteLogo = !empty($rawLogo) ? uploaded_image_url($rawLogo, $defaultLogo) : $defaultLogo;
        $shareImage = uploaded_image_url($rawHero, $siteLogo);
        $siteLogoAbsolute = $absoluteUrl($siteLogo);
        $shareImageAbsolute = $absoluteUrl($shareImage);
        $locale = str_replace('_', '-', app()->getLocale());
        $socialLinks = array_filter([
            get_option('facebook'),
            get_option('instagram'),
            get_option('twitter'),
            get_option('linkedin'),
            get_option('tiktok'),
        ]);
        $contactPhone = trim((string) get_option('contact_phone'));
        $contactEmail = trim((string) get_option('contact_email'));
        $searchUrl = url('shop') . '?q={search_term_string}';
        $contactPoint = $contactPhone ? [[
            '@type' => 'ContactPoint',
            'telephone' => $contactPhone,
            'contactType' => 'customer service',
            'areaServed' => 'KE'
        ]] : null;
        $orgSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $siteName,
            'url' => $siteUrl,
            'logo' => $siteLogoAbsolute,
            'email' => $contactEmail ?: null,
            'contactPoint' => $contactPoint,
            'sameAs' => !empty($socialLinks) ? array_values($socialLinks) : null
        ];
        $websiteSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $siteName,
            'url' => $siteUrl,
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => $searchUrl,
                'query-input' => 'required name=search_term_string'
            ]
        ];
    @endphp

    <title>
        @hasSection('title')
            @yield('title') | {{ $siteName }}
        @else
            {{ $siteName }}
        @endif
    </title>

    <meta name="description"
          content="@yield('meta_description', $siteDesc)">
    <meta name="keywords"
          content="@yield('meta_keywords', $siteName . ', networking, Starlink, CCTV, WiFi, routers, access points, Kenya')">
    <meta name="robots" content="@yield('robots', 'index,follow')">
    <meta name="application-name" content="{{ $siteName }}">
    <meta name="theme-color" content="#ff8a1e">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', $siteName)" />
    <meta property="og:description" content="@yield('og_description', $siteDesc)" />
    <meta property="og:image" content="@yield('og_image', $shareImageAbsolute)" />
    <meta property="og:url" content="@yield('og_url', url()->current())" />
    <meta property="og:site_name" content="{{ $siteName }}" />
    <meta property="og:type" content="@yield('og_type', 'website')" />
    <meta property="og:locale" content="{{ $locale }}" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@yield('twitter_site', $siteUrl)" />
    <meta name="twitter:title" content="@yield('twitter_title', $siteName)" />
    <meta name="twitter:description" content="@yield('twitter_description', $siteDesc)" />
    <meta name="twitter:image" content="@yield('twitter_image', $shareImageAbsolute)" />

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $faviconUrl }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $faviconUrl }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $faviconUrl }}">
    <link rel="manifest" href="{{ asset('dark/assets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ $faviconUrl }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ url('/sitemap.xml') }}">

    <!-- Removed dark mode init -->

    <!-- Preload Critical CSS -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" as="style">

    <!-- Bootstrap 5 (inline from theme root) -->
    <style>
        @include('theme.orbit.bootstrap.inline_css')
    </style>
    <!-- Google Fonts for Orbit theme -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Orbit theme CSS kept alongside views (inline include) -->
    <style>
        @include('theme.orbit.css.inline')
    </style>

  
    <!-- Structured data -->
    <script type="application/ld+json">
        @json($orgSchema)
    </script>
    <script type="application/ld+json">
        @json($websiteSchema)
    </script>

    @stack('meta')
    @yield('styles')
    @stack('styles')
    
</head>

<body>

    @php
        $categories = \App\Models\Category::orderBy('name')->get();
        $cart = session()->get('cart', []);
        $cartCount = is_array($cart) ? count($cart) : 0;
    @endphp

    <!-- New Bootstrap Header -->
    <header class="header-area">
        <!-- Topbar -->
        <div class="bg-light border-bottom small">
            <div class="container py-1 d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    @php
                        $notice = trim((string) get_option('top_notice'));
                    @endphp
                    @if($notice !== '')
                        <i class="fas fa-bullhorn me-2"></i>{{ $notice }}
                    @else
                        @php
                            $currency = get_option('currency_symbol', 'KSh');
                            $threshold = (int) get_option('free_shipping_threshold', 10000);
                        @endphp
                        <i class="fas fa-truck me-2"></i>Free delivery for orders over {{ $currency }} {{ number_format($threshold, 0) }}
                    @endif
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('wishlist.index') }}" class="text-decoration-none text-muted"><i class="fas fa-heart me-1"></i>Wishlist</a>
                    <a href="{{ route('login') }}" class="text-decoration-none text-muted"><i class="fas fa-user me-1"></i>Sign in</a>
                    <span class="text-muted d-none d-md-inline"><i class="fas fa-headset me-1"></i>{{ get_option('contact_phone') }}</span>
                    
                </div>
            </div>
        </div>

        <!-- Main Navbar with Search -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top" role="navigation" aria-label="Primary">
            <div class="container">
                @php
                    $siteName = get_option('site_name', 'Orbitlink Solutions');
                    $rawLogo = get_option('logo');
                    $logoUrl = !empty($rawLogo)
                        ? uploaded_image_url($rawLogo, asset('assets/images/orbitlinks-logo.webp'))
                        : asset('assets/images/orbitlinks-logo.webp');
                @endphp
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    @if($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $siteName }} logo" width="180" height="60" style="height:60px; max-height:60px; width:auto; object-fit:contain;">
                    @else
                        <span class="fw-bold" style="font-size:1.25rem;">{{ $siteName }}</span>
                    @endif
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNavbar">
                    <!-- Search -->
                    <form action="{{ url('shop') }}" method="get" class="ms-lg-3 my-3 my-lg-0 flex-grow-1">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search for products..." aria-label="Search products" required>
                            <button class="btn btn-accent" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>

                    <!-- Icons -->
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                        <li class="nav-item d-none d-lg-inline">
                            <a class="nav-link" href="{{ route('wishlist.index') }}" aria-label="Wishlist">
                                <i class="fas fa-heart"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('cart.view') }}" aria-label="Cart">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $cartCount }}</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                                <li><a class="dropdown-item" href="{{ route('login') }}">Sign in</a></li>
                                <li><a class="dropdown-item" href="{{ route('account.dashboard') }}">My Account</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('contacts') }}">Help & Support</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="d-lg-none w-100 mt-3">
                        <div class="border-top pt-3">
                            <ul class="navbar-nav">
                                @foreach(\App\Models\Menu::all() as $menu)
                                    <li class="nav-item"><a class="nav-link" href="{{ $menu->url }}">{{ $menu->name }}</a></li>
                                @endforeach
                            </ul>
                            <div class="navbar-text mt-2"><i class="fas fa-headset me-1"></i>Need Help? {{ get_option('contact_phone') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Category / Menu bar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white category-bar">
            <div class="container flex-column">
                <div class="w-100 d-flex align-items-center flex-wrap">
                    <div class="collapse navbar-collapse w-100" id="menuBar">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            @foreach(\App\Models\Menu::all() as $menu)
                                <li class="nav-item"><a class="nav-link" href="{{ $menu->url }}">{{ $menu->name }}</a></li>
                            @endforeach
                        </ul>
                        <span class="navbar-text d-none d-lg-inline"><i class="fas fa-headset me-1"></i>Need Help? {{ get_option('contact_phone') }}</span>
                    </div>
                </div>

                <div class="category-strip w-100">
                    <button class="category-nav category-prev" type="button" aria-label="Scroll categories left">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="category-scroll" aria-label="Shop categories">
                        @foreach($categories->take(12) as $cat)
                            <a class="category-pill" href="{{ route('view_product_category', ['slug' => $cat->slug]) }}">
                                <span class="category-pill-icon">
                                    @if(!empty($cat->photo))
                                        <img src="{{ uploaded_image_url($cat->photo) }}" alt="{{ $cat->name }}" width="40" height="40" loading="lazy">
                                    @else
                                        <i class="fas fa-plus"></i>
                                    @endif
                                </span>
                                <span class="category-pill-text">{{ $cat->name }}</span>
                            </a>
                        @endforeach
                        @if($categories->count() > 12)
                            <a class="category-pill category-pill-outline" href="{{ route('allcategories') }}">
                                <span class="category-pill-icon"><i class="fas fa-th-large"></i></span>
                                <span class="category-pill-text">All Categories</span>
                            </a>
                        @endif
                    </div>
                    <button class="category-nav category-next" type="button" aria-label="Scroll categories right">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    {{-- LEGACY HEADER REMOVED: commented out to avoid duplicates
    <header class="header-area header-style-1 header-height-2 legacy-header">
      
        <!-- Header Middle -->
        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                        <a href="{{ url('/') }}">
                            <img src="{{ get_option('logo') }}" alt="logo">
                        </a>
                    </div>

                    <?php $categories = \App\Models\Category::all(); ?>
                    <div class="header-right">
                        <div class="search-style-2">
                            <form action="{{ url('shop') }}" method="get">
                                <input type="text" name="q" placeholder="Search for products..." required>
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
                            <div class="d-flex justify-content-end align-items-center py-3 gap-2">
                                <!-- Wishlist Icon -->
                                <div class="me-3">
                                    <a href="{{ route('wishlist.index') }}" class="text-dark text-decoration-none d-flex align-items-center">
                                        <img class="svgInject" alt="Wishlist" src="{{ url('/') }}/lucare/assets/imgs/theme/icons/icon-heart.svg" width="24" height="24">
                                        <span class="badge bg-dark ms-2">0</span>
                                    </a>
                                </div>
                                <!-- Cart Icon -->
                                <div class="me-3">
                                    <a href="{{ route('cart.view') }}" class="text-dark text-decoration-none d-flex align-items-center">
                                        <img alt="Cart" src="{{ url('/') }}/lucare/assets/imgs/theme/icons/icon-cart.svg" width="24" height="24">
                                        <span class="badge bg-dark ms-2">{{ count(Session::get('cart', [])) }}</span>
                                    </a>
                                </div>
                                <!-- Theme Toggle -->
                                <div class="me-3">
                                    
                                </div>
                                <!-- Account Button -->
                                <div>
                                    <a href="{{ route('login') }}" class="btn btn-success d-flex align-items-center px-3 py-2 rounded-pill text-white">
                                        <i class="bi bi-person-circle me-2" style="font-size: 20px;"></i> Account
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Header Bottom -->
        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="{{ url('/') }}"><img src="{{ get_option('logo') }}" alt="logo"></a>
                    </div>
                    <div class="header-nav d-none d-lg-flex">
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block">
                            <nav>
                                <ul>
                                    @foreach(\App\Models\Menu::all() as $menu)
                                        <li>
                                            <a href="{{ $menu->url }}">{{ $menu->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="hotline d-none d-lg-block">
                        <p><i class="fi-rs-headset"></i><span>Need Help?</span> {{ get_option('contact_phone') }}</p>
                    </div>

                    <!-- Mobile Header Actions -->
                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                <a href="{{ route('wishlist.index') }}">
                                    <img alt="Wishlist" src="{{ url('/') }}/lucare/assets/imgs/theme/icons/icon-heart.svg">
                                    <span class="pro-count white">0</span>
                                </a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="{{ url('shop-cart') }}">
                                    <img alt="Cart" src="{{ url('/') }}/lucare/assets/imgs/theme/icons/icon-cart.svg">
                                    <span class="pro-count white">0</span>
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                    <ul>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="{{ url('shop-product') }}"><img alt="Product" src="{{ url('/') }}/lucare/assets/imgs/shop/thumbnail-3.jpg"></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="{{ url('shop-product') }}">Plain Striola Shirts</a></h4>
                                                <h3><span>1 × </span>$800.00</h3>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="{{ url('shop-product') }}"><img alt="Product" src="{{ url('/') }}/lucare/assets/imgs/shop/thumbnail-4.jpg"></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="{{ url('shop-product') }}">Macbook Pro 2022</a></h4>
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
                                            <a href="{{ url('shop-cart') }}">View cart</a>
                                            <a href="shop-checkout.html">Checkout</a>
                                        </div>
                                    </div>
                                </div>
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
                    <!-- End Mobile Header Actions -->
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Header -->
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
                        <input type="text" name="q" placeholder="Search for beauty products…">
                        <button type="submit"><i class="fi-rs-search"></i></button>
                    </form>
                </div>
                <div class="mobile-menu-wrap mobile-header-border">
                    <!-- Mobile Menu Start -->
                    <nav>
                        <ul class="mobile-menu">
                            @foreach(\App\Models\Menu::all() as $menu)
                                <li class="menu-item-has-children">
                                    <a href="{{ $menu->url }}">{{ $menu->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                    <!-- Mobile Menu End -->
                </div>
                <div class="mobile-header-info-wrap mobile-header-border">
                    <div class="single-mobile-header-info mt-30">
                        <a href="page-contact.html">Our Location</a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="{{ url('login') }}">Log In / Sign Up</a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="#">{{ get_option('contact_phone') }}</a>
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
    --}}

    <main class="main">
        @include('flash_msg')
        <!-- Your main content goes here -->
