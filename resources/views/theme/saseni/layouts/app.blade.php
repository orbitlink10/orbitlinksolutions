<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>
        @section('title') 
            {{ get_option('site_name', 'Nara Luxury International') }} 
        @show
    </title>

    <meta name="description" content="@yield('meta_description', 'Nara Luxury International - Premium Quality Products and Services')">
    <meta name="keywords" content="@yield('meta_keywords', 'Luxury, Nara, International, Premium, Quality Products, Services')">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', 'Nara Luxury International | Premium Quality Products and Services')" />
    <meta property="og:description" content="@yield('og_description', 'Discover luxury products and services at Nara Luxury International. Offering premium quality and world-class service.')" />
    <meta property="og:image" content="@yield('og_image', asset('default-image.jpg'))" />
    <meta property="og:url" content="@yield('og_url', url('/'))" />
    <meta property="og:site_name" content="{{ get_option('site_name', 'Nara Luxury International') }}" />
    <meta property="og:type" content="@yield('og_type', 'website')" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@yield('twitter_site', url('/'))" />
    <meta name="twitter:title" content="@yield('twitter_title', get_option('site_name', 'Nara Luxury International'))" />
    <meta name="twitter:description" content="@yield('twitter_description', 'Discover luxury products and services at Nara Luxury International. Offering premium quality and world-class service.')" />
    <meta name="twitter:image" content="@yield('twitter_image', get_option('hero_image'))" />

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ get_option('favicon', asset('default-favicon.png')) }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ get_option('favicon', asset('default-favicon.png')) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ get_option('favicon', asset('default-favicon.png')) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ get_option('favicon', asset('default-favicon.png')) }}">
    <link rel="manifest" href="{{ asset('dark/assets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ get_option('favicon', asset('default-favicon.png')) }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Preload Critical CSS -->
    <link rel="preload" href="{{ url('/') }}/lucare/assets/css/main.css?v=3.4" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" as="style">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ url('/') }}/lucare/assets/css/main_nara.css?v=3.4">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/') }}/lucare/assets/css/style.css">

    <!-- Custom UI Enhancements -->
    <style>
        /* Header & Navigation Styling */
        .header-area {
            background: #fff;
            transition: background 0.3s ease, box-shadow 0.3s ease;
        }
        .header-area.sticky {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header-nav ul li a {
            transition: color 0.3s ease;
        }
        .header-nav ul li a:hover {
            color: #d9534f;
        }
        /* Mobile Menu Styling */
        .mobile-menu a {
            padding: 10px;
            display: block;
            color: #333;
            border-bottom: 1px solid #eee;
            transition: background 0.3s ease;
        }
        .mobile-menu a:hover {
            background: #f8f8f8;
        }
        /* Search Input Enhancements */
        .search-style-2 input {
            border: 1px solid #ddd;
            padding: 8px 12px;
            border-radius: 25px;
            transition: border-color 0.3s ease;
        }
        .search-style-2 input:focus {
            border-color: #d9534f;
        }
        /* Icon Hover Effects */
        .header-action-icon-2 img {
            transition: transform 0.3s ease;
        }
        .header-action-icon-2:hover img {
            transform: scale(1.1);
        }
    </style>
    @stack('meta')
    @yield('styles')
    
</head>

<body>

    <header class="header-area header-style-1 header-height-2">
      
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
                        <input type="text" name="q" placeholder="Search for items…">
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

    <main class="main">
        @include('flash_msg')
        <!-- Your main content goes here -->
