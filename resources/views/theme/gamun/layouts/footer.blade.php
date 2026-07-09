</main>
<footer class="main">
 
    <section class="section-padding footer-mid">
        <div class="container pt-15 pb-20">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="widget-about font-md mb-md-5 mb-lg-0">
                        <div class="logo logo-width-1 wow fadeIn animated">
                            <a href="index.html"><img src="{{ get_option('logo') }}" alt="logo"></a>
                        </div>
                        <h5 class="mt-20 mb-10 fw-600 text-grey-4 wow fadeIn animated">Contact</h5>
                        <p class="wow fadeIn animated">
                            <strong>Address: </strong>{{ get_option('address') }}
                        </p>
                        <p class="wow fadeIn animated">
                            <strong>Phone: </strong>{{ get_option('contact_phone') }}
                        </p>
                        <p class="wow fadeIn animated">
                            <strong>Hours: </strong>9:00 - 18:00, Mon - Sat
                        </p>



                        <h5 class="mb-10 mt-30 fw-600 text-grey-4 wow fadeIn animated">Follow Us</h5>


                        <div class="mobile-social-icon wow fadeIn animated mb-sm-5 mb-md-0">
                            <a href="{{ get_option('facebook') }}"><img src="{{ url('/') }}/lucare/assets/imgs/theme/icons/icon-facebook.svg" alt=""></a>
                            <a href="{{ get_option('twitter') }}"><img src="{{ url('/') }}/lucare/assets/imgs/theme/icons/icon-twitter.svg" alt=""></a>
                            <a href="{{ get_option('instagram') }}"><img src="{{ url('/') }}/lucare/assets/imgs/theme/icons/icon-instagram.svg" alt=""></a>
                         
                         
                        </div>

                        
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <h5 class="widget-title wow fadeIn animated">About</h5>
                    <ul class="footer-list wow fadeIn animated mb-sm-5 mb-md-0">
                        <li><a href="{{ route('about_us') }}">About Us</a></li>
                        <li><a href="{{ route('faq') }}">FAQs</a></li>
                        <li><a href="{{ url('terms') }}">Terms &amp; Conditions</a></li>
                        <li><a href="{{ route('contacts') }}">Contact Us</a></li>
                        <li><a href="{{ route('contacts') }}">Support Center</a></li>
                    </ul>
                </div>
                <div class="col-lg-2  col-md-3">
                    <h5 class="widget-title wow fadeIn animated">My Account</h5>
                    <ul class="footer-list wow fadeIn animated">
                        <li><a href="{{ route('login') }}">Sign In</a></li>
                        <li><a href="{{ route('cart.view') }}">View Cart</a></li>
                        <li><a href="{{ route('login') }}">Track My Order</a></li>
                        <li><a href="{{ route('contacts') }}">Help</a></li>
                        <li><a href="{{ url('account/orders') }}">Orders</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="widget-title wow fadeIn animated">Install App</h5>
                    <div class="row">
                        <div class="col-md-8 col-lg-12">
                            <p class="wow fadeIn animated">From App Store or Google Play</p>
                            <div class="download-app wow fadeIn animated">
                                <a href="#" class="hover-up mb-sm-4 mb-lg-0"><img class="active" src="{{ url('/') }}/lucare/assets/imgs/theme/app-store.jpg" alt=""></a>
                                <a href="#" class="hover-up"><img src="{{ url('/') }}/lucare/assets/imgs/theme/google-play.jpg" alt=""></a>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-12 mt-md-3 mt-lg-0">
                            <p class="mb-20 wow fadeIn animated">Secured Payment Gateways</p>
                            <img class="wow fadeIn animated" src="{{ url('/') }}/lucare/assets/imgs/theme/payment-method.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container pb-20 wow fadeIn animated">
        <div class="row">
            <div class="col-12 mb-20">
                <div class="footer-bottom"></div>
            </div>
            <div class="col-lg-6">
                <p class="float-md-left font-sm text-muted mb-0">&copy; 2025, <strong class="text-brand">{{ get_option('site_name') }}</strong></p>
            </div>
            <div class="col-lg-6">
                <p class="text-lg-end text-start font-sm text-muted mb-0">
                    Designed by <a href="http://zama.co.ke" target="_blank">Zama Web Experts</a>. All rights reserved
                </p>
            </div>
        </div>
    </div>
</footer>

    <!-- Preloader Start -->
    <!-- <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <h5 class="mb-10">Now Loading</h5>
                    <div class="loader">
                        <div class="bar bar1"></div>
                        <div class="bar bar2"></div>
                        <div class="bar bar3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Vendor JS-->
    <script src="{{ url('/') }}/lucare/assets/js/vendor/modernizr-3.6.0.min.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/vendor/jquery-3.6.0.min.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/vendor/jquery-migrate-3.3.0.min.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/vendor/bootstrap.bundle.min.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/slick.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/jquery.syotimer.min.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/wow.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/jquery-ui.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/perfect-scrollbar.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/magnific-popup.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/select2.min.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/waypoints.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/counterup.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/jquery.countdown.min.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/images-loaded.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/isotope.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/scrollup.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/jquery.vticker-min.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/jquery.theia.sticky.js" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/jquery.elevatezoom.js" defer></script>
    <!-- Template  JS -->
    <script src="{{ url('/') }}/lucare/assets/js/main.js?v=3.4" defer></script>
    <script src="{{ url('/') }}/lucare/assets/js/shop.js?v=3.4" defer></script>




<nav class="navbar navbar-light bg-light fixed-bottom border-top shadow-sm d-md-none mobile-bottom-nav">
  <div class="container-fluid px-3">
    <ul class="navbar-nav nav-justified w-100 d-flex flex-row">
      <!-- Home Link -->
      <li class="nav-item">
        <a class="nav-link text-center {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
          <i class="fas fa-home fs-4 d-block"></i>
          <span class="d-block small">Home</span>
        </a>
      </li>
      <!-- Products Link -->
      <li class="nav-item">
        <a class="nav-link text-center {{ request()->is('shop*') ? 'active' : '' }}" href="{{ url('shop') }}">
          <i class="fas fa-store fs-4 d-block"></i>
          <span class="d-block small">Products</span>
        </a>
      </li>
      <!-- My Account Link -->
      <li class="nav-item">
        <a class="nav-link text-center {{ request()->is('account*') ? 'active' : '' }}" href="{{ route('account.dashboard') }}">
          <i class="fas fa-user-cog fs-4 d-block"></i>
          <span class="d-block small">My Account</span>
        </a>
      </li>
    </ul>
  </div>
</nav>

 <style>
/* Mobile bottom nav refined */
.mobile-bottom-nav { background: rgba(255,255,255,.92); backdrop-filter: saturate(180%) blur(16px); }
.mobile-bottom-nav .nav-link { color:#6c757d; transition: color .25s ease; padding:6px 0 2px; }
.mobile-bottom-nav .nav-link:hover, .mobile-bottom-nav .nav-link.active { color:#0d6efd; font-weight:600; }
.mobile-bottom-nav .nav-link i { margin-bottom:2px; font-size:1.2rem; }


</style>
{!! get_option('chat') !!}
@stack('scripts')




  @include('chat_widget')



</body>

</html>
