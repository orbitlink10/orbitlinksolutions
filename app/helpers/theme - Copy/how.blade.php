@extends('theme.layouts.main')
@section('title') How to Get Starlink Internet in Kenya @endsection
@section('main')
<section class="py-0" id="header">
    <div class="bg-holder" style="background-image:url(dark/assets/img/gallery/header-bg.png);background-position:right top;background-size:contain;">
    </div>
    <!--/.bg-holder-->

    <div class="container">
        <div class="row align-items-center min-vh-75 min-vh-xl-100">
            <div class="col-md-8 col-lg-6 text-md-start text-center">
                <h1 class="display-1 lh-sm text-uppercase text-light">How to Get Starlink Internet in Kenya</h1>
                <p class="lead">Follow these straightforward steps to acquire and set up your Starlink internet service in Kenya, ensuring fast and reliable connectivity.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-6" id="purchase-kit" style="margin-top: -100px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="fs-4 fs-lg-3 lh-sm text-uppercase">1. Purchase the Kit</h3>
                <p>The initial step is to purchase the Starlink Kit, which includes essential equipment for satellite internet.</p>
                <ul>
                    <li><strong>Standard Actuated Kit:</strong> Ksh. 45,000. Ideal for households and businesses.</li>
                    <li><strong>Flat High Performance Kit:</strong> Ksh. 377,000. Perfect for RVs, nomads, and campers.</li>
                </ul>
                <p><a class="btn btn-primary" href="{{ route('product')}}">Buy Starlink Kit</a></p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h2 class="fs-3 fs-lg-3 lh-sm text-uppercase">2. Install the Starlink Dish</h2>
                <p>Upon receiving your Starlink Kit, you need to install the satellite dish. Ensure it has a clear view of the sky for optimal connectivity.</p>
                <ul>
                    <li>Mount the dish securely using the provided tripod or mount.</li>
                    <li>Position the dish to achieve the best satellite signal.</li>
                </ul>
  
            </div>
        </div>
 
        <div class="row">
            <div class="col-lg-12">
                <h2 class="fs-3 fs-lg-3 lh-sm text-uppercase">3. Set Up the Router and Connect Devices</h2>
                <p>Connect the Starlink router to the dish using the provided cables. Power on the router and use the Starlink app to configure your network settings and connect your devices.</p>
        
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h2 class="fs-3 fs-lg-3 lh-sm text-uppercase">4. Activate Your Service</h2>
                <p>Once the physical setup is completed, your Starlink system will connect to the satellite network. Follow the on-screen instructions in the Starlink app or website to complete the activation process.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h2 class="fs-3 fs-lg-3 lh-sm text-uppercase">5. Select Your Preferred Starlink Package</h2>
                <p>Choose from available Starlink packages in Kenya:</p>
                <h4>Residential Plan</h4>
                <ul>
                    <li>Ksh 1,300/month (50GB)</li>
                    <li>Ksh 6,500/month (Unlimited)</li>
                </ul>
                <h4>Business Plan</h4>
                <ul>
                    <li>Ksh 8,000/month (Unlimited)</li>
                </ul>
                <p>For more detailed packages <a style="color: #fff;" href="https://www.starlink.com/service-plans">Click here</a> </p>
            </div>
        </div>
 
        <div class="row">
            <div class="col-lg-12">
                <h2 class="fs-3 fs-lg-3 lh-sm text-uppercase">6. Monitor and Optimize</h2>
                <p>Utilize the Starlink app to monitor your connection quality and manage your network settings. Adjust the dish’s position or network settings as necessary to ensure optimal performance.</p>

            </div>
        </div>
    </div>
</section>




@endsection
