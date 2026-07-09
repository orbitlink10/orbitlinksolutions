@extends('theme.layouts.main')

@section('main')
<style>
    /* Light Theme Styles */
    .form-control-light {
        background-color: #ffffff; /* Light background color */
        color: #212529; /* Dark text color */
        border: 1px solid #ced4da; /* Light border color */
    }

    .form-control-light:focus {
        background-color: #e9ecef; /* Slightly darker background on focus */
        color: #212529; /* Dark text color */
        border-color: #80bdff; /* Bootstrap focus border color */
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25); /* Focus shadow */
    }

    .card {
        background-color: #f8f9fa; /* Light background for the card */
        border: 1px solid #ced4da; /* Light border for the card */
    }

    .card-title {
        color: #212529; /* Dark text color for card title */
    }

    .alert {
        border-radius: 0.25rem;
    }

    .text-danger {
        font-size: 0.875rem; /* Adjust error text size */
        color: #dc3545; /* Bootstrap danger color */
    }

    .btn-link {
        color: #007bff; /* Bootstrap primary color for the link */
    }
</style>

<!-- Start Login Page -->
<section class="login-page py-5" style="margin-top: 100px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Login</h4>

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control form-control-light" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control form-control-light" id="password" name="password" required>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">Login</button>
                            </div>

                            <div class="text-center">
                                <p class="text-dark">Don't have an account? <a href="{{ route('register') }}" class="btn btn-link">Register</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Login Page -->
@endsection
