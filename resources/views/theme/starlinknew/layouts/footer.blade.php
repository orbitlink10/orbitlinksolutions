</main>
<footer class="bg-dark text-light pt-5">
  <div class="container">
    <div class="row g-4 pb-5">

      <!-- About & Contact -->
      <div class="col-md-4">
        <a href="{{ url('/') }}" class="d-inline-block mb-3">
          <img src="{{ uploaded_image_url(get_option('logo'), asset('assets/images/orbitlinks-logo.webp')) }}" alt="{{ get_option('site_name') }} logo" height="50">
        </a>
        <ul class="list-unstyled mb-3">
          <li class="mb-2"><i class="bi bi-geo-alt-fill me-2"></i>{{ get_option('address') }}</li>
          <li class="mb-2">
            <i class="bi bi-telephone-fill me-2"></i>
            <a href="tel:{{ get_option('contact_phone') }}" class="text-light text-decoration-none">
              {{ get_option('contact_phone') }}
            </a>
          </li>
          <li><i class="bi bi-clock-fill me-2"></i>Mon–Sat: 9AM–6PM</li>
          <li><i class="bi bi-clock-fill me-2"></i>Mon&ndash;Sat: 9AM&ndash;6PM</li>
        </ul>
        <div class="d-flex gap-3">
          <a href="{{ get_option('facebook') }}" target="_blank" class="social-icon"><i class="bi bi-facebook"></i></a>
          <a href="{{ get_option('twitter') }}"  target="_blank" class="social-icon"><i class="bi bi-twitter"></i></a>
          <a href="{{ get_option('instagram') }}" target="_blank" class="social-icon"><i class="bi bi-instagram"></i></a>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="col-md-2">
        <h5 class="fw-bold mb-3">About</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="{{ route('about_us') }}"     class="text-light link-hover">About Us</a></li>
          <li class="mb-2"><a href="{{ route('faq') }}"          class="text-light link-hover">FAQs</a></li>
          <li class="mb-2"><a href="{{ url('terms') }}"           class="text-light link-hover">Terms &amp; Conditions</a></li>
          <li class="mb-2"><a href="{{ route('contacts') }}"      class="text-light link-hover">Contact Us</a></li>
          <li><a href="{{ route('contacts') }}"             class="text-light link-hover">Support Center</a></li>
        </ul>
      </div>

      <!-- Account Links -->
      <div class="col-md-2">
        <h5 class="fw-bold mb-3">My Account</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="{{ route('login') }}"       class="text-light link-hover">Sign In</a></li>
          <li class="mb-2"><a href="{{ route('cart.view') }}"   class="text-light link-hover">View Cart</a></li>
          <li class="mb-2"><a href="{{ url('orders.track') }}"class="text-light link-hover">Track Order</a></li>
          <li class="mb-2"><a href="{{ url('help') }}"        class="text-light link-hover">Help</a></li>
          <li><a href="{{ url('account/orders') }}"             class="text-light link-hover">My Orders</a></li>
        </ul>
      </div>

      <!-- Newsletter -->
      <div class="col-md-4">
        <h5 class="fw-bold mb-3">Subscribe</h5>
        <form action="{{ url('newsletter.subscribe') }}" method="POST" class="d-flex">
          @csrf
          <input type="email" name="email" placeholder="Your email address"
                 class="form-control me-2" required>
          <button class="btn btn-primary">Subscribe</button>
        </form>
        <p class="mt-3 small text-muted">
          Stay updated with our latest Starlink Kenya offers and tips.
        </p>
      </div>

    </div>
  </div>

  <div class="bg-secondary text-center py-3">
    <div class="container">
      <p class="mb-1 small">
        &copy; {{ date('Y') }} <strong class="text-light">{{ get_option('site_name') }}</strong>.
        All rights reserved.
      </p>
      <p class="mb-0 small">
        <em>Disclaimer:</em> SpacelinkKenya.co.ke is an independent specialist and not affiliated with Starlink.
      </p>
    </div>
  </div>

  @push('styles')
  <style>
    /* Hide legacy malformed opening hours and show corrected one */
    footer .col-md-4:first-of-type ul.list-unstyled.mb-3 li:nth-child(3) {
      display: none !important;
    }
    .link-hover:hover {
      color: #0d6efd !important;
      text-decoration: underline;
    }
    .social-icon {
      font-size: 1.25rem;
      color: #adb5bd;
      transition: color .3s;
    }
    .social-icon:hover {
      color: #ffffff;
    }
  </style>
  @endpush
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
{!! get_option('chat') !!}
@stack('scripts')




  @include('chat_widget')



</body>

</html>
