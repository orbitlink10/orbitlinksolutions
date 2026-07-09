@extends('theme.electro.layouts.main')
@section('title') Starlink kenya price @endsection
@section('main')
<section class="py-6" id="starlink-pricing" style="margin-top: 50px;">
    <div class="container">
        <!-- Initial Installation Cost Section -->
        <div class="row text-center mb-5">
            <div class="col-md-12">
                <h1 class="fs-2 fs-lg-4 text-uppercase text-light">Starlink kenya price</h1>
                <p class="lead text-muted">The first step to getting Starlink Internet in Kenya is to buy the Starlink Kit. You can either choose the <strong>Standard Actuated Kit</strong> or the <strong>Flat High Performance Kit</strong>, depending on your needs.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <!-- Standard Actuated Kit -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card bg-dark text-light shadow border-light">
                    <div class="card-body">
                        <h5 class="card-title fs-2 text-uppercase">Standard Actuated Kit</h5>
                        <p class="card-text fs-4 mb-3">Ksh 45,500</p>
                        <p class="card-text">Best for households and businesses. Includes a satellite dish, Wi-Fi router, power supply, cables, and mounting tripod.</p>
                    </div>
                </div>
            </div>
            
            <!-- Flat High Performance Kit -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card bg-dark text-light shadow border-light">
                    <div class="card-body">
                        <h5 class="card-title fs-2 text-uppercase">Flat High Performance Kit</h5>
                        <p class="card-text fs-4 mb-3">Ksh 377,000</p>
                        <p class="card-text">Best for RVs, nomads, and campers. Includes a high-performance satellite dish and additional accessories for mobile use.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- MK Homestyles Monthly Subscription Cost Section -->
        <div class="row text-center mt-5 mb-5">
            <div class="col-md-12">
                <h2 class="fs-2 fs-lg-4 text-uppercase text-light">MK Homestyles Monthly Subscription Cost</h2>
                <p class="lead text-muted">Choose a subscription plan that suits your needs.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <!-- Residential Plan -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card bg-dark text-light shadow border-light">
                    <div class="card-body">
                        <h5 class="card-title fs-2 text-uppercase">Residential Plan</h5>
                        <p class="card-text ">Ksh 1,300/month (50GB)</p>
                        <p class="card-text">Ksh 6,500/month (Unlimited)</p>
                    </div>
                </div>
            </div>
            
            <!-- Business Plan -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card bg-dark text-light shadow border-light">
                    <div class="card-body">
                        <h5 class="card-title fs-2 text-uppercase">Business Plan</h5>
                        <p class="card-text">Ksh 8,000/month (Unlimited)</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional Information Section -->
        <div class="row mt-5 text-center ">
            <div class="col-md-12">
                <h3 class="fs-2 text-uppercase text-light">Order Your Starlink Kit Now

</h3>
                <p class="text-muted">
                Step into the future of high-speed internet with Starlink. Secure your kit today and unlock limitless possibilities with seamless connectivity across Kenya. Our team is ready to assist with installation and setup—get started now!
                </p>
                <a href="{{ route('product') }}" class="btn btn-primary">Buy Starlink kit now</a>
            </div>
        </div>
    </div>
</section>
@endsection
