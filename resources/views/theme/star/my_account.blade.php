@extends('theme.star.layouts.main')

@section('main')
    <!-- Page Header Start -->
    <section class="page-header bg-light text-dark py-5">
        <div class="page-header-bg" style="background-image: url('{{ asset('assets/images/backgrounds/page-header-bg.jpg') }}'); background-size: cover; background-position: center; opacity: 0.8;"></div>
        <div class="container">
            <div class="page-header__inner">
                <ul class="breadcrumb list-unstyled d-flex">
                    <li class="breadcrumb-item"><a href="/" class="text-dark">Home</a></li>
                    <li class="breadcrumb-item active text-dark">My Account</li>
                </ul>
                <h2 class="page-header-title text-dark">My Account</h2>
            </div>
        </div>
    </section>
    <!-- Page Header End -->

    <!-- Account Dashboard Start -->
    <section class="account-dashboard py-5 bg-light text-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <!-- Sidebar Navigation -->
                    <div class="list-group bg-light">
                        <a href="{{ route('account.dashboard') }}" class="list-group-item list-group-item-action bg-secondary text-light">Dashboard</a>
                        <a href="{{ route('account.orders') }}" class="list-group-item list-group-item-action bg-secondary text-light">My Orders</a>
                        <a href="{{ route('account.details') }}" class="list-group-item list-group-item-action bg-secondary text-light">Account Details</a>
                        <a href="{{ route('account.payments') }}" class="list-group-item list-group-item-action bg-secondary text-light">Payments</a>
                        <a href="{{ route('account.logout') }}" class="list-group-item list-group-item-action bg-secondary text-light">Logout</a>
                    </div>
                </div>

                <div class="col-lg-9">
                    @include('admin.flash_msg')
                    <!-- Dashboard Content -->
                    @yield('account-content')
                </div>
            </div>
        </div>
    </section>
    <!-- Account Dashboard End -->
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0-beta3/js/bootstrap.min.js"></script>
@endsection
