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

        </div>
    </div>
</footer>


    <!-- Vendor JS-->
    <script src="{{ url('/') }}/lucare/assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/vendor/jquery-migrate-3.3.0.min.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/slick.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/jquery.syotimer.min.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/wow.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/jquery-ui.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/perfect-scrollbar.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/magnific-popup.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/select2.min.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/waypoints.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/counterup.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/jquery.countdown.min.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/images-loaded.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/isotope.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/scrollup.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/jquery.vticker-min.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/jquery.theia.sticky.js"></script>
    <script src="{{ url('/') }}/lucare/assets/js/plugins/jquery.elevatezoom.js"></script>
    <!-- Template  JS -->
    <script src="{{ url('/') }}/lucare/assets/js/main.js?v=3.4"></script>
    <script src="{{ url('/') }}/lucare/assets/js/shop.js?v=3.4"></script>




<nav class="navbar navbar-light bg-light fixed-bottom border-top shadow-sm d-md-none">
  <div class="container-fluid px-3">
    <ul class="navbar-nav nav-justified w-100 d-flex flex-row">
      <!-- Home Link -->
      <li class="nav-item">
        <a class="nav-link text-center" href="{{ url('/') }}">
          <i class="fas fa-home fs-4 d-block"></i>
          <span class="d-block small">Home</span>
        </a>
      </li>
      <!-- Products Link -->
      <li class="nav-item">
        <a class="nav-link text-center" href="{{ url('shop') }}">
          <i class="fas fa-store fs-4 d-block"></i>
          <span class="d-block small">Products</span>
        </a>
      </li>
      <!-- My Account Link -->
      <li class="nav-item">
        <a class="nav-link text-center" href="{{ route('account.dashboard') }}">
          <i class="fas fa-user-cog fs-4 d-block"></i>
          <span class="d-block small">My Account</span>
        </a>
      </li>
    </ul>
  </div>
</nav>

 <style>
.navbar-light .nav-link {
  color: #6c757d; /* Neutral gray for default state */
  transition: color 0.3s ease-in-out;
}

.navbar-light .nav-link:hover {
  color: #0d6efd; /* Highlight on hover */
}

.navbar-light .nav-link i {
  margin-bottom: 2px; /* Spacing between icon and label */
}

.navbar-light .nav-link.active {
  color: #0d6efd; /* Highlight active link */
  font-weight: bold;
}


</style>
{!! get_option('chat') !!}
  @yield('scripts')
</body>

</html>