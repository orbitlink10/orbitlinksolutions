@extends('theme.gamun.layouts.main')

@section('main')


    <!-- Account Dashboard Start -->
    <section class="account-dashboard py-5 bg-white text-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <!-- Sidebar Navigation -->
                    <div class="list-group">
                        <a href="{{ route('account.dashboard') }}" 
                           class="list-group-item list-group-item-action {{ Route::is('account.dashboard') ? 'active bg-primary text-white' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('account.orders') }}" 
                           class="list-group-item list-group-item-action {{ Route::is('account.orders') ? 'active bg-primary text-white' : '' }}">
                            My Orders
                        </a>
                        <a href="{{ route('account.details') }}" 
                           class="list-group-item list-group-item-action {{ Route::is('account.details') ? 'active bg-primary text-white' : '' }}">
                            Account Details
                        </a>
                        <a href="{{ route('account.payments') }}" 
                           class="list-group-item list-group-item-action {{ Route::is('account.payments') ? 'active bg-primary text-white' : '' }}">
                            Payments
                        </a>
                        <a href="{{ route('account.logout') }}" 
                           class="list-group-item list-group-item-action {{ Route::is('account.logout') ? 'active bg-primary text-white' : '' }}">
                            Logout
                        </a>
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
