@extends('theme.layouts.main')

@section('main')
<section class="py-0" id="header">
        <div class="bg-holder" style="background-image:url(dark/assets/img/gallery/header-bg.png);background-position:right top;background-size:contain;">
        </div>
        <!--/.bg-holder-->

        <div class="container">
          <div class="row align-items-center min-vh-75 min-vh-xl-100">
            <div class="col-md-8 col-lg-6 text-md-start text-center">
              <h2 class="display-1 lh-sm text-uppercase text-light">Starlink <br class="d-none d-xxl-block" /> Kenya</h2>
              <p>Discover Starlink Kenya, your trusted provider of Starlink kit and professional installation services in Kenya. We offer high-quality satellite
              internet solutions to ensure fast, reliable connectivity across the countr</p>
              <div class="pt-4">
                <a class="btn btn-sm btn-outline-primary me-3" href="#collections">Buy Startlink Kit</a>

            </div>
            </div>
          </div>
        </div>
      </section>
      <section class="bg-black py-8 pt-0" id="store">
        <div class="bg-holder" style="background-image:url(dark/assets/img/gallery/store-bg.png);background-position:left bottom;background-size:contain;">
        </div>
        <!--/.bg-holder-->

        <div class="container-lg">
          <div class="row flex-center">
            <div class="col-6 order-md-0 text-center text-md-start"></div>
            <div class="col-sm-10 col-md-6 col-lg-6 text-center text-md-start">
              <div class="col-4 position-relative ms-auto py-5"><a class="carousel-control-prev carousel-icon z-index-2" href="#carouselExampleFade" role="button" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></a><a class="carousel-control-next carousel-icon z-index-2" href="#carouselExampleFade" role="button" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></a></div>
              <div class="carousel slide carousel-fade" id="carouselExampleFade" data-bs-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <div class="row h-100">
                      <div class="col-12">
                        <h5 class="text-uppercase">Fast Satellite Internet Across Kenya</h5>
                        <p class="my-4 pe-xl-5">Starlink Kenya provides high-speed satellite internet solutions across Kenya, offering Starlink equipment, expert installation, and dedicated support. Our mission is to enhance connectivity, even in remote and underserved areas.net technology in Kenya.</p>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="row h-100">
                      <div class="col-12">
                        <h5 class=""> Starlink Kenya benefits </h5>
                        <p class="my-4 pe-xl-5">Starlink Kenya delivers cutting-edge satellite internet technology that ensures fast, consistent connectivity, even in remote or underserved areas where traditional services fall short. Our team of certified professionals provides expert installation services. </p>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="row h-100">
                      <div class="col-12">
                        <h5 class="">Save money by bundling your internet with Starlink Kenya</h5>
                        <p class="my-4 pe-xl-5">Get high-speed satellite internet with Starlink Kenya at a great price. Certified installation ensures reliable connectivity in remote areas.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="py-0 pb-6" id="collections">
        <div class="container">
          <div class="row h-100">
          
            <div class="col-12">
         
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-latest" role="tabpanel" aria-labelledby="nav-latest-tab">
                  <div class="carousel slide" id="carouselLatest" data-bs-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item active" data-bs-interval="10000">
                        <div class="row h-100 align-items-center">
@foreach($products as $product)

                          <div class="col-sm-6 col-md-4 mb-3 mb-md-0">
                            <div class="card bg-black text-white p-6 pb-8"><img class="card-img" src="/images?path={{$product->photo}}" alt="..." />
                              <div class="card-img-overlay bg-dark-gradient d-flex flex-column-reverse align-items-center">
                                <h6 class="text-primary">KES {{ $product->price }}</h6>
                                <h4 class="text-light">{{ $product->name }}</h4>
                              </div><a class="stretched-link" href="{{ route('product_details', $product->slug) }}"></a>
                            </div>
                          </div>


                          @endforeach

                          <div class="col-sm-6 col-md-8 mb-3 mb-md-0">
                                        <!-- Content for the second column -->
                <div class="card bg-dark text-white">
                    <div class="card-body">

                    <h5 class="">Starlink Kits</h5>
                <!-- Additional content for the first column -->
                <p class="mt-3">
                To set up Starlink in Kenya, the first step is to purchase the Starlink Kit, which includes a satellite dish, Wi-Fi router, power supply, cables, and a mounting tripod. The Standard Actuated Kit costs Ksh 45,000, suitable for households and businesses, while the Flat High Performance Kit is priced at Ksh 377,000, ideal for RVs, nomads, and campers.
<br><br>
After receiving the kit, install the dish in a location with a clear view of the sky, using the Starlink app to find the best spot. Connect the router to the dish, power it on, and set up your Wi-Fi network via the app.
<br><br>
Activate your service through the Starlink app or website, then select a suitable package. Available plans include a Residential Plan at Ksh 1,300/m for 50GB or Ksh 6,500/m for unlimited data, and a Business Plan at Ksh 8,000/m for unlimited data.
<br><br>
Finally, use the Starlink app to monitor and optimize your connection, adjusting the dish's position or network settings as needed.                </p>
             
                        <a href="{{ url('how-to-order') }}" class="btn btn-outline-light">Learn More</a>



                    </div>
                </div>


                <div class="card bg-dark text-white mt-4">
                    <div class="card-body">
                        <h6 class="card-title text-primary">Get Your Starlink Kit Today!</h6>
                        <p class="card-text">
                        Ready to experience high-speed internet anywhere in Kenya? Purchase your Starlink Kit with us today! Whether you're setting up at home, on the road, or in remote areas, we've got the right kit for you. Don't miss out—order now and stay connected wherever you are!
                        </p>
                   
                     

                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-outline-light">Buy now</button>
                        </form>


                    </div>
                </div>
                
           
                          </div>



                        </div>
                      </div>
                 
                 
                    </div>
                  </div>
                </div>
           
              </div>
            </div>
          </div>
        </div>
      </section>



      <section class="py-0 pb-6" id="collections">
        <div class="container">
          <div class="row h-100">
          
            <div class="col-12">
         
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-latest" role="tabpanel" aria-labelledby="nav-latest-tab">
                  <div class="carousel slide" id="carouselLatest" data-bs-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item active" data-bs-interval="10000">
                        <div class="row h-100 align-items-center">


                          <div class="col-sm-6 col-md-8 mb-3 mb-md-0">
                                        <!-- Content for the second column -->
                <div class="">
                    <div class="">

                    <div class="accordion" id="faqAccordion">
                    <h2 class="text-light">Starlink Kenya FAQS</h2>
  <div class="accordion-item">
    <h2 class="accordion-header" id="faq1">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
        What is included in the Starlink Kit?
      </button>
    </h2>
    <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
      <div class="accordion-body">
        The Starlink Kit includes a satellite dish, Wi-Fi router, power supply, cables, and a mounting tripod.
      </div>
    </div>
  </div>

  <!-- FAQ 2 -->
  <div class="accordion-item">
    <h2 class="accordion-header" id="faq2">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
        How much does the Starlink Kit cost?
      </button>
    </h2>
    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
      <div class="accordion-body">
        The Standard Actuated Kit costs Ksh 45,000, suitable for households and businesses. The Flat High Performance Kit is priced at Ksh 377,000, ideal for RVs, nomads, and campers.
      </div>
    </div>
  </div>

  <!-- FAQ 3 -->
  <div class="accordion-item">
    <h2 class="accordion-header" id="faq3">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
        Where should I install the Starlink dish?
      </button>
    </h2>
    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
      <div class="accordion-body">
        The dish requires a clear view of the sky to connect with Starlink satellites. You can place it on your roof, on a tripod, or on the ground in an open area.
      </div>
    </div>
  </div>

  <!-- FAQ 4 -->
  <div class="accordion-item">
    <h2 class="accordion-header" id="faq4">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
        What are the available Starlink packages?
      </button>
    </h2>
    <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faqAccordion">
      <div class="accordion-body">
        The available packages include:
        <ul>
          <li>Residential Plan: Ksh 1,300/m (50GB) or Ksh 6,500/m (Unlimited)</li>
          <li>Business Plan: Ksh 8,000/m (Unlimited)</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- FAQ 5 -->
  <div class="accordion-item">
    <h2 class="accordion-header" id="faq5">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
        How do I activate my Starlink service?
      </button>
    </h2>
    <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="faq5" data-bs-parent="#faqAccordion">
      <div class="accordion-body">
        Once the physical setup is complete, your Starlink system will automatically connect to the satellite network. You may need to complete the activation process via the Starlink app or website by following the on-screen instructions.
      </div>
    </div>
  </div>
</div>

             
                        <a href="{{ url('starlink-kenya-price') }}" class="btn btn-outline-light">Starlink kenya price</a>



                    </div>
                </div>


    
                
           
                          </div>




                          @foreach($products as $product)

                          <div class="col-sm-6 col-md-4 mb-3 mb-md-0">
                            <div class="card bg-black text-white p-6 pb-8"><img class="card-img" src="/images?path={{$product->photo}}" alt="..." />
                              <div class="card-img-overlay bg-dark-gradient d-flex flex-column-reverse align-items-center">
                                <h6 class="text-primary">KES {{ $product->price }}</h6>
                                <h4 class="text-light">{{ $product->name }}</h4>
                              </div><a class="stretched-link" href="{{ route('product_details', $product->slug) }}"></a>
                            </div>
                          </div>


                          @endforeach



                        </div>
                      </div>
                 
                 
                    </div>
                  </div>
                </div>
           
              </div>
            </div>
          </div>
        </div>
      </section>



      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="py-6 ">

       <div class="container">
          <div class="row">
            <div class="col-sm-12 col-lg-12" >
                <div class="card"><div class="card-body" style="color: #000000;">
            {!! $options->where('option_key', 'home_page_description')->first()->option_value !!}
            </div>
            </div>
            </div>
          </div>
        </div> 
        <!-- end of .container-->



      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->











@endsection
