<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <title>{{ get_option('site_name') }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ get_option('favicon') }}">
    
    <!-- Google Font: Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    
    <!-- iCheck, JQVMap, Daterangepicker, Summernote, OverlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    
    <!-- AdminLTE Theme -->
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/adminlte.min.css') }}">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-footer-fixed {{ Auth::check() && Auth::user()->is_admin() ? 'admin-skin' : 'account-skin' }}">
    <div class="wrapper">


<!-- Sidebar -->
<aside class="main-sidebar elevation-4">
    <div class="sticky-sidebar">
    <div class="sidebar">
        <!-- Site Name or Branding -->
<div class="user-panel mt-3 pb-3 mb-3 d-flex sticky-panel">
    <div class="image">
        <a href="{{ url('/') }}" class="text-dark text-decoration-none">
            <h3 class="text-dark mb-0">{{ get_option('site_name') }}</h3>
        </a>
    </div>
</div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
                @include('layouts.menu_links')
            </ul>
        </nav>
    </div>
    </div>
</aside>





        
<div class="d-flex justify-content-end mb-3">
    <!-- Flash Message -->
    @include('flash_msg')
</div>




           
                    @yield('content')
                
    <style>
   
        @media (max-width: 576px) {
            .navbar {
                display: none; /* Hide top navbar on small screens */
            }
            .bottom-navbar {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                background-color: #003366; /* Dark blue */
                box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.2);
                display: flex;
                justify-content: space-around;
                padding: 10px 0;
                z-index: 1000;
            }
            .bottom-navbar a {
                color: #adb5bd;
                font-size: 14px;
                text-decoration: none;
                text-align: center;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .bottom-navbar a:hover {
                color: #fff;
            }
            .bottom-navbar i {
                font-size: 20px;
                margin-bottom: 5px;
            }
            .bottom-navbar span {
                font-size: 12px;
            }
        }
    </style>
     
@if(Auth::user() && Auth::user()->is_admin())
    <!-- Bottom Navbar for Admins (small screens) -->
    <div class="bottom-navbar d-md-none">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.index') ? 'active' : '' }}">
            <i class="fas fa-book"></i>
            <span>Orders</span>
        </a>
        <a href="{{ route('invoices.index') }}" class="{{ request()->routeIs('invoices.index') ? 'active' : '' }}">
            <i class="fas fa-credit-card"></i>
            <span>Invoices</span>
        </a>

                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="fas fas fa-users"></i>
            <span>Clients</span>
        </a>

        <a href="#" data-widget="pushmenu" role="button" aria-label="Open menu">
            <i class="fas fa-bars"></i>
            <span>More</span>
        </a>

    </div>
@else
    <!-- Bottom Navbar for Regular Users (small screens) -->
    <div class="bottom-navbar d-md-none">
        <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('account.orders') }}" class="{{ request()->routeIs('account.orders') ? 'active' : '' }}">
            <i class="fas fa-book"></i>
            <span>Orders</span>
        </a>
        <a href="{{ route('account.payments') }}" class="{{ request()->routeIs('account.payments') ? 'active' : '' }}">
            <i class="fas fa-credit-card"></i>
            <span>Payments</span>
        </a>
        <a href="#" data-widget="pushmenu" role="button" aria-label="Open menu">
            <i class="fas fa-bars"></i>
            <span>More</span>
        </a>
    </div>
@endif


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/sparklines/sparkline.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/js/pages/dashboard.js') }}"></script>

    <script>
        $(function () {
            // Initialize Select2 Elements
            $('.select2').select2();
            $('.select2bs4').select2({ theme: 'bootstrap4' });

            // Datepicker and Mask
            $('#reservationdate').datetimepicker({ format: 'L' });
            $('#reservation').daterangepicker();
            $('[data-mask]').inputmask();
        });
    </script>


    @stack('scripts') <!-- For pushed scripts -->
    @yield('scripts') <!-- For directly yielded scripts -->
</body>

</html>
