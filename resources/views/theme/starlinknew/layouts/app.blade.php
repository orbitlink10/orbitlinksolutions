<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @section('title') 
        {{ get_option('site_name', 'Starlink Kenya Installers') }} 
        @show
    </title>

    <meta name="description" content="@yield('meta_description', 'Starlink Kenya Installers - Fast, Reliable Satellite Internet Installation Services in Kenya')">
    <meta name="keywords" content="@yield('meta_keywords', 'Starlink, Kenya, Internet, Installation, Installers, Connectivity, Satellite')">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', 'Starlink Kenya Installers | Fast & Reliable Installation Services')" />
    <meta property="og:description" content="@yield('og_description', 'Professional Starlink installation services across Kenya. Book your installation today.')" />
    <meta property="og:image" content="@yield('og_image', get_option('hero_image'))" />
    <meta property="og:url" content="@yield('og_url', url('/'))" />
    <meta property="og:site_name" content="{{ get_option('site_name', 'Starlink Kenya Installers') }}" />
    <meta property="og:type" content="@yield('og_type', 'website')" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@yield('twitter_site', url('/'))" />
    <meta name="twitter:title" content="@yield('twitter_title', get_option('site_name', 'Starlink Kenya Installers'))" />
    <meta name="twitter:description" content="@yield('twitter_description', 'Get Starlink installed by trusted experts in Kenya.')" />
    <meta name="twitter:image" content="@yield('twitter_image', get_option('hero_image'))" />

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ get_option('favicon', asset('default-favicon.png')) }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ get_option('favicon', asset('default-favicon.png')) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ get_option('favicon', asset('default-favicon.png')) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ get_option('favicon', asset('default-favicon.png')) }}">
    <link rel="manifest" href="{{ asset('dark/assets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ get_option('favicon', asset('default-favicon.png')) }}">

    <!-- Canonical URL -->
    @php
        $canonicalBase = rtrim(config('app.url') ?: 'https://starlinkkenyainstallers.co.ke', '/');
        $canonicalPath = request()->getPathInfo();
        $canonicalUrl  = $canonicalBase . $canonicalPath;
    @endphp
    <link rel="canonical" href="@yield('canonical', $canonicalUrl)">

    {{-- Structured Data: LocalBusiness and WebSite --}}
    @php
        $siteUrl   = rtrim(config('app.url') ?: url('/'), '/');
        $siteName  = get_option('site_name', 'Starlink Kenya Installers');
        $logo      = uploaded_image_url(get_option('logo'), asset('assets/images/orbitlinks-logo.webp'));
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
            'priceRange' => 'KES',
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

    <!-- Performance: preconnect for Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Framework first -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Theme base + icons -->
    <link rel="stylesheet" href="{{ url('/') }}/lucare/assets/css/main_nara.css?v=3.4">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom overrides -->
    <link rel="stylesheet" href="{{ asset('assets/starlinknew/style.css') }}">

<style>
  :root {
    --starlink-primary: #003366;
    --starlink-accent: #001B44;
    --starlink-dark: #222222;
    --starlink-light: #ffffff;
    --starlink-gradient: linear-gradient(90deg, #003366 0%, #001B44 100%);
    --bs-body-font-family: 'Roboto', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

  body {
    font-family: var(--bs-body-font-family);
    background: #f5f7fa;
    color: var(--starlink-dark);
    scroll-behavior: smooth;
  }

  /* Core Styles adjusted to Roboto */
  .glass-card {
    background: rgba(0, 27, 68, 0.7);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 8px 32px 0 rgba(0, 51, 102, 0.2);
    color: var(--starlink-light);
  }

  .highlight-box {
    background-color: var(--starlink-light);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px;
  }

  .highlight-box:hover {
    transform: translateY(-8px);
    box-shadow: 0 1.5rem 3rem rgba(0, 0, 0, 0.15);
  }

  .card-hover {
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.05);
  }

  .card-hover:hover {
    transform: translateY(-8px);
    box-shadow: 0 1rem 2rem rgba(0, 27, 68, 0.3);
  }

  .icon-circle {
    width: 4.5rem;
    height: 4.5rem;
    background: linear-gradient(135deg, rgba(0, 27, 68, 0.1), rgba(0, 27, 68, 0.2));
    color: var(--starlink-primary);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    margin: 0 auto 1.5rem;
    transition: all 0.3s ease;
  }

  .card-hover:hover .icon-circle {
    transform: scale(1.1);
    background: linear-gradient(135deg, rgba(0, 27, 68, 0.2), rgba(0, 27, 68, 0.3));
  }

  .text-gradient {
    background: var(--starlink-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline-block;
  }

  .btn-modern {
    background: var(--starlink-primary);
    color: var(--starlink-light);
    border-radius: 50px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    border: none;
  }

  .btn-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 27, 68, 0.3);
    background: var(--starlink-accent);
  }

  .product-card {
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.05);
    background: var(--starlink-light);
    transition: all 0.3s ease;
  }

  .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 27, 68, 0.1);
  }

  .testimonial-card {
    border-radius: 12px;
    background: var(--starlink-light);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
  }

  @keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
    100% { transform: translateY(0px); }
  }

  .floating {
    animation: float 6s ease-in-out infinite;
  }

  .nav-tabs {
    border-bottom: 2px solid rgba(0, 0, 0, 0.05);
  }

  .nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    position: relative;
  }

  .nav-tabs .nav-link.active {
    color: var(--starlink-primary);
    background: transparent;
  }

  .nav-tabs .nav-link.active:after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 3px;
    background: var(--starlink-primary);
    border-radius: 3px 3px 0 0;
  }

  .section-py {
    padding: 3rem 0;
  }

  @media (max-width: 768px) {
    .display-4 {
      font-size: 2.5rem;
    }

    .section-py {
      padding: 2rem 0;
    }
  }

  a {
    text-decoration: none;
    color: inherit;
  }

  a:hover {
    text-decoration: none;
    color: var(--starlink-primary);
  }

  .bg-holder {
  pointer-events: none;
}

</style>

   @stack('meta')
    @yield('styles')
    @stack('styles')
</head>


<body>





    <header class="header-area header-style-1 header-height-2">


        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                        <a href="{{ url('/')}}">
                            <img src="{{ $logo }}" alt="{{ $siteName }} logo" loading="lazy">
                        </a>
                    </div>

                    <?php 

                    $categories = \App\Models\Category::all();
                    ?>
                    <div class="header-right">
                        <div class="search-style-2">
                            <form action="{{ url('shop') }}" method="get">
                                <input type="text" name="q" placeholder="Search for items..." aria-label="Search" required>
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
        
        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="{{ url('/')}}"><img src="{{ $logo }}" alt="{{ $siteName }} logo"></a>
                    </div>
                    <div class="header-nav d-none d-lg-flex">

                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block">
                            <nav>
                                <ul>


                                    @foreach(\App\Models\Menu::all() as $menu)
                                        @php
                                            $currentUrl = url()->current();
                                            $menuUrl = \Illuminate\Support\Str::startsWith($menu->url, ['http://','https://'])
                                                ? $menu->url
                                                : url($menu->url);
                                            $isActive = rtrim($menuUrl, '/') === rtrim($currentUrl, '/');
                                        @endphp
                                        <li>
                                            <a href="{{ $menuUrl }}" class="{{ $isActive ? 'active' : '' }}">{{ $menu->name }}</a>
                                        </li>
                                    @endforeach




                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="hotline d-none d-lg-block">
                        <p><i class="fi-rs-headset"></i><span>Need Help?</span> {{ get_option('contact_phone') }} </p>
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
                        <a href="{{ url('/') }}"><img src="{{ $logo }}" alt="{{ $siteName }} logo" loading="lazy"></a>
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
                    <input type="text" name="q" placeholder="Search for items..." aria-label="Search">
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
                            $menuUrl = \Illuminate\Support\Str::startsWith($menu->url, ['http://','https://'])
                                ? $menu->url
                                : url($menu->url);
                            $isActive = rtrim($menuUrl, '/') === rtrim($currentUrl, '/');
                        @endphp
                        <li class="menu-item-has-children">
                            <a href="{{ $menuUrl }}" class="{{ $isActive ? 'active' : '' }}">{{ \Illuminate\Support\Str::title($menu->name) }}</a>
                        </li>
                        @endforeach

                        
                    </ul>
                </nav>
                <!-- mobile menu end -->
            </div>
            <div class="mobile-header-info-wrap mobile-header-border">
                <div class="single-mobile-header-info mt-30">
                    <a href="{{ route('contacts') }}"> Our location </a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="{{ url('login') }}">Log In / Sign Up </a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="tel:{{ get_option('contact_phone') }}">{{ get_option('contact_phone') }} </a>
                </div>
            </div>
            <div class="mobile-social-icon">
                <h5 class="mb-15 text-grey-4">Follow Us</h5>
                @php
                    $socialIcons = [
                        'facebook'  => 'icon-facebook.svg',
                        'twitter'   => 'icon-twitter.svg',
                        'instagram' => 'icon-instagram.svg',
                        'pinterest' => 'icon-pinterest.svg',
                        'youtube'   => 'icon-youtube.svg',
                    ];
                @endphp
                @foreach($socialIcons as $key => $icon)
                    @php $href = get_option($key); @endphp
                    @if(!empty($href))
                        <a href="{{ $href }}" target="_blank" rel="noopener">
                            <img src="{{ url('/') }}/lucare/assets/imgs/theme/icons/{{ $icon }}" alt="{{ ucfirst($key) }}">
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
<main class="main">


   @include('flash_msg')
