@extends('theme.layouts.main')
@section('title') Thank You for Your Booking! @endsection
@section('main')

<!-- Page Header Start -->
<section class="page-header">
    <div class="page-header-bg" style="background-image: url({{ asset('dark/assets/img/gallery/header-bg.png') }});"></div>
    <div class="container">
        <div class="page-header__inner text-center">
            <h1 class="page-header__title">Thank You for Your Booking!</h1>
            <p class="page-header__description">We have received your rental booking. You will receive a confirmation message soon!</p>
        </div>
    </div>
</section>
<!-- Page Header End -->

<!-- Thank You Section Start -->
<section class="thank-you-section py-5">
    <div class="container text-center">
        <h2 class="text-success">Your Booking is Confirmed!</h2>
        <p class="lead">Thank you for booking the Starlink Kit with us. We will contact you shortly with further details.</p>
        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Go to Home</a>
    </div>
</section>
<!-- Thank You Section End -->

@endsection
