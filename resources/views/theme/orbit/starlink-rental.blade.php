@extends('theme.orbit.layouts.main')
@section('title', 'Starlink Kit Rental')

@section('main')

<!-- Page Header Start -->
<section class="page-header">
    <div class="page-header-bg" style="background-image: url({{ asset('dark/assets/img/gallery/header-bg.png') }});"></div>
    <div class="container text-center">
        <div class="page-header__inner">
            <h1 class="page-header__title">Starlink Kit Rental</h1>
            <p class="page-header__description">Experience high-speed satellite internet anywhere in Kenya!</p>
        </div>
    </div>
</section>
<!-- Page Header End -->

<!-- Rental Details Start -->
<section class="rental-details py-5">
    <div class="container">

        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="rental-details__top">
                    <h3 class="rental-details__title text-dark">Starlink Satellite Internet Rental</h3>
                </div>
                <div class="rental-details__content">
                    <p class="rental-details__content-text">
                        Enjoy unlimited high-speed internet anywhere in Kenya with our Starlink rental. Perfect for remote work, travel, and adventures!
                    </p>
                    <p class="rental-details__availability text-muted">Available for immediate rental.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('rental.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label for="customer_name" class="form-label">Customer Name</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
                    @error('customer_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="tel" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number') }}" required>
                    @error('phone_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            
            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
                    @error('start_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}" required>
                    @error('end_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="1" required>
                    @error('quantity')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary btn-lg">Book Now</button>
            </div>
        </form>
    </div>
</section>
<!-- Rental Details End -->

<!-- Rental Description Start -->
<section class="rental-description py-6 bg-light">
    <div class="container">
        <h3 class="rental-description__title">About the Starlink Kit Rental</h3>
        <p>
            The Starlink rental package includes everything you need to get online in minutes:
        </p>
        <ul>
            <li>Starlink dish with base</li>
            <li>WiFi Router</li>
            <li>Power Cable and Starlink Cable</li>
            <li>Convenient carry case</li>
        </ul>
        <p>
            Enjoy unlimited high-speed internet across Kenya, ideal for both travel and remote work.
            In-motion use is supported, making it perfect for road trips and outdoor adventures. Coastal coverage is available within 12 nautical miles in Starlink-supported territories.
        </p>
    </div>
</section>
<!-- Rental Description End -->

@endsection
