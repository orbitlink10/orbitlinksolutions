</main>
<footer class="main footer-modern">
    @php
        $siteName = get_option('site_name', 'Orbitlink Solutions');
        $rawLogo = get_option('logo');
        $logoUrl = null;
        if (!empty($rawLogo)) {
            $isAbs = \Illuminate\Support\Str::startsWith($rawLogo, ['http://','https://','//']);
            $logoUrl = $isAbs ? $rawLogo : url($rawLogo);
        }
        $footerDesc = trim(strip_tags((string) get_option('contact_description')));
        if ($footerDesc === '') {
            $footerDesc = 'Networking, Starlink, CCTV, WiFi, and ICT solutions across Kenya.';
        }
    @endphp
    <section class="footer-top-chips py-4">
        <div class="container">
            <div class="footer-value-grid">
                <div class="footer-value">
                    <span class="value-icon"><i class="fas fa-truck"></i></span>
                    <span class="value-title">Fast Delivery</span>
                </div>
                <div class="footer-value">
                    <span class="value-icon"><i class="fas fa-shield-alt"></i></span>
                    <span class="value-title">Genuine Warranty</span>
                </div>
                <div class="footer-value">
                    <span class="value-icon"><i class="fas fa-credit-card"></i></span>
                    <span class="value-title">Secure Payments</span>
                </div>
                <div class="footer-value">
                    <span class="value-icon"><i class="fas fa-headset"></i></span>
                    <span class="value-title">7-Day Support</span>
                </div>
            </div>
        </div>
    </section>
 
    <section class="footer-mid">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5 col-md-6">
                    <div class="footer-brand">
                        <span class="footer-logo-text">{{ $siteName }}</span>
                        <p class="footer-description">{{ \Illuminate\Support\Str::words($footerDesc, 26, '...') }}</p>
                        <ul class="footer-contact">
                            @if(get_option('address'))
                                <li><i class="fas fa-map-marker-alt"></i><span>{{ get_option('address') }}</span></li>
                            @endif
                            @if(get_option('contact_phone'))
                                <li><i class="fas fa-phone"></i><a href="tel:{{ preg_replace('/\s+/', '', get_option('contact_phone')) }}">{{ get_option('contact_phone') }}</a></li>
                            @endif
                            @if(get_option('contact_email'))
                                <li><i class="fas fa-envelope"></i><a href="mailto:{{ get_option('contact_email') }}">{{ get_option('contact_email') }}</a></li>
                            @endif
                            <li><i class="fas fa-clock"></i><span>Mon - Sat: 9:00 - 18:00</span></li>
                        </ul>
                        <div class="footer-social">
                            @if(get_option('facebook'))
                                <a target="_blank" href="{{ get_option('facebook') }}" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            @endif
                            @if(get_option('instagram'))
                                <a target="_blank" href="{{ get_option('instagram') }}" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            @endif
                            @if(get_option('tiktok'))
                                <a target="_blank" href="{{ get_option('tiktok') }}" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                            @endif
                            @if(get_option('linkedin'))
                                <a target="_blank" href="{{ get_option('linkedin') }}" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Company</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('about_us') }}">About Us</a></li>
                        <li><a href="{{ route('faq') }}">FAQs</a></li>
                        <li><a href="{{ url('terms') }}">Terms &amp; Conditions</a></li>
                        <li><a href="{{ route('contacts') }}">Contact Us</a></li>
                        <li><a href="{{ route('contacts') }}">Support Center</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-title">My Account</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('login') }}">Sign In</a></li>
                        <li><a href="{{ route('cart.view') }}">View Cart</a></li>
                        <li><a href="{{ route('login') }}">Track My Order</a></li>
                        <li><a href="{{ route('contacts') }}">Help</a></li>
                        <li><a href="{{ url('account/orders') }}">Orders</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<div class="footer-bottom">
    <div class="container">
        <div class="footer-bottom-inner">
            <p class="footer-copy">&copy; {{ date('Y') }} {{ $siteName }}. All Rights Reserved.</p>
            <div class="footer-payments" aria-label="Accepted payments">
                <i class="fab fa-cc-visa"></i>
                <i class="fab fa-cc-mastercard"></i>
                <i class="fab fa-cc-paypal"></i>
            </div>
            <div class="footer-legal">
                <a href="#">Privacy Policy</a>
                <a href="{{ url('terms') }}">Terms of Use</a>
                <a href="{{ route('contacts') }}">Contact Us</a>
            </div>
        </div>
    </div>
</div>

</footer>


<!-- Back to Top Button -->
<button id="backToTop" title="Back to top" aria-label="Back to top">
  <i class="fas fa-arrow-up"></i>
  <span class="visually-hidden">Back to top</span>
  </button>

    <!-- Core JS -->
    <script src="{{ url('/') }}/lucare/assets/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 inline from theme root -->
    <script>
        @include('theme.orbit.bootstrap.inline_js')
    </script>
    <!-- Only keep what we use -->
    <script src="{{ url('/') }}/lucare/assets/js/plugins/slick.js"></script>
    <script>
      (function($){
        $(function(){
          $('.category-strip').each(function(){
            var $strip = $(this);
            var $slider = $strip.find('.category-scroll');
            var $prev = $strip.find('.category-prev');
            var $next = $strip.find('.category-next');

            function scrollFallback(direction) {
              var el = $slider.get(0);
              if (!el) return;
              var delta = Math.min(el.clientWidth * 0.8, 420);
              el.scrollBy({ left: direction * delta, behavior: 'smooth' });
            }

            if ($slider.length && $.fn.slick) {
              if (!$slider.hasClass('slick-initialized')) {
                $slider.slick({
                  arrows: false,
                  dots: false,
                  infinite: true,
                  autoplay: true,
                  autoplaySpeed: 3200,
                  speed: 550,
                  cssEase: 'cubic-bezier(0.22, 1, 0.36, 1)',
                  slidesToScroll: 1,
                  variableWidth: true,
                  swipeToSlide: true,
                  touchThreshold: 10,
                  draggable: true,
                  pauseOnHover: true,
                  pauseOnFocus: true,
                  accessibility: true
                });
              }
              $prev.on('click', function(e){
                e.preventDefault();
                $slider.slick('slickPrev');
              });
              $next.on('click', function(e){
                e.preventDefault();
                $slider.slick('slickNext');
              });
            } else {
              $prev.on('click', function(e){
                e.preventDefault();
                scrollFallback(-1);
              });
              $next.on('click', function(e){
                e.preventDefault();
                scrollFallback(1);
              });
            }
          });
        });
      })(jQuery);
    </script>

    @stack('scripts')
    @yield('scripts')

    <script>
      // Back to Top behavior (dark mode removed)
      (function() {
        var backBtn = document.getElementById('backToTop');
        function onScroll() {
          if (!backBtn) return;
          if (window.scrollY > 300) backBtn.classList.add('show');
          else backBtn.classList.remove('show');
        }
        window.addEventListener('scroll', onScroll, { passive: true });
        if (backBtn) {
          backBtn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
          });
        }
        onScroll();
      })();
    </script>



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

{!! get_option('chat') !!}
</body>

</html>
