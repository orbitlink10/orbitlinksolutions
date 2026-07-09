<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Dynamic Title and Description -->
    <title>@yield('title', 'Starlink Kenya | Authorized Reseller')</title>
    <meta name="description" content="@yield('meta_description', 'Discover Starlink Kenya, your trusted provider of Starlink kits and professional installation services in Kenya. We offer high-quality satellite internet solutions to ensure fast, reliable connectivity across the country.')">


<meta name="robots" content="index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large"/>

  @section('social-meta')

  <link rel="canonical" href="{{ url()->current() }}" />
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', 'Starlink Kenya | Reliable Satellite Internet')" />
    <meta property="og:description" content="@yield('og_description', 'Providing Starlink kits and installations for seamless internet connectivity.')" />
    <meta property="og:image" content="@yield('og_image', asset('default-image.jpg'))" />
    <meta property="og:url" content="@yield('og_url', url('/'))" />
    <meta property="og:site_name" content="{{ get_option('site_name', 'Starlink Kenya') }}" />
    <meta property="og:type" content="@yield('og_type', 'website')" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@yield('twitter_site', url('/'))" />
    <meta name="twitter:title" content="@yield('twitter_title', get_option('site_name', 'Starlink Kenya'))" />
    <meta name="twitter:description" content="@yield('twitter_description', 'Starlink Kenya offers reliable satellite internet connectivity solutions.')" />
    <meta name="twitter:image" content="@yield('twitter_image', asset('default-image.jpg'))" />
   @show


    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ get_option('favicon', asset('default-favicon.png')) }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ get_option('favicon', asset('default-favicon.png')) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ get_option('favicon', asset('default-favicon.png')) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ get_option('favicon', asset('default-favicon.png')) }}">
    <link rel="manifest" href="{{ asset('dark/assets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ get_option('favicon', asset('default-favicon.png')) }}">

    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

    <!-- Additional Metadata -->
    @stack('meta')

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #212529;
        }

        .nav-link {
            font-weight: 500;
            color: #343a40;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #007bff;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-right: none;
            padding: 10px 20px;
            transition: box-shadow 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
            border-color: #007bff;
        }

        .btn {
            padding: 10px 20px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-dark {
            background-color: #212529;
            color: #ffffff;
        }

        .btn-dark:hover {
            background-color: #343a40;
            color: #ffffff;
        }

        .badge {
            background-color: #dc3545;
        }
    </style>
    
</head>


<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <!-- Brand / Logo -->
            <a class="navbar-brand" href="{{ url('/') }}">{{ get_option('site_name', 'Starlink Kenya') }}</a>

            <!-- Mobile Menu Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @foreach(\App\Models\Menu::all() as $menu)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ $menu->url }}">{{ $menu->name }}</a>
                        </li>
                    @endforeach

                    <!-- Contact Info -->
                    <li class="nav-item d-flex align-items-center ms-3">
                        <strong><i class="fas fa-phone"></i> Call/WhatsApp: {{ get_option('contact_phone') }}</strong>
                    </li>

                    <!-- Authentication Links -->
                    @if(Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('account.dashboard') }}">My Account</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endif

                    <!-- Cart -->
                    <li class="nav-item position-relative">
                        <a class="nav-link" href="{{ route('cart.view') }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill">
                                {{ array_sum(array_column(session('cart', []), 'quantity')) }}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
