</main>
<footer class="main footer-modern">
    <section class="footer-top-chips py-3">
        <div class="container">
            <div class="row g-3 text-center text-md-start">
                <div class="col-6 col-md-3"><div class="chip"><i class="fas fa-truck"></i><span>Fast Delivery</span></div></div>
                <div class="col-6 col-md-3"><div class="chip"><i class="fas fa-shield-alt"></i><span>Genuine Warranty</span></div></div>
                <div class="col-6 col-md-3"><div class="chip"><i class="fas fa-credit-card"></i><span>Secure Payments</span></div></div>
                <div class="col-6 col-md-3"><div class="chip"><i class="fas fa-headset"></i><span>7‑Day Support</span></div></div>
            </div>
        </div>
    </section>
 
    <section class="section-padding footer-mid">
        <div class="container pt-15 pb-20">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="widget-about font-md mb-md-5 mb-lg-0">
                        <h5 class="mt-20 mb-10 fw-600 text-grey-4 wow fadeIn animated">Contact</h5>
                        <ul class="list-unstyled footer-contact wow fadeIn animated">
                            <li><i class="fas fa-map-marker-alt me-2"></i><span>{{ get_option('address') }}</span></li>
                            <li><i class="fas fa-phone me-2"></i><a href="tel:{{ preg_replace('/\s+/', '', get_option('contact_phone')) }}">{{ get_option('contact_phone') }}</a></li>
                            <li><i class="fas fa-clock me-2"></i><span>9:00 - 18:00, Mon - Sat</span></li>
                        </ul>



                        <h5 class="mb-10 mt-30 fw-600 text-grey-4 wow fadeIn animated">Follow Us</h5>


                        <div class="footer-social d-flex gap-2 align-items-center mb-sm-5 mb-md-0">
                            <a target="_blank" href="{{ get_option('facebook') }}" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a target="_blank" href="{{ get_option('instagram') }}" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a target="_blank" href="{{ get_option('tiktok') }}" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        </div>

                        
                    </div>
                </div>
                <div class="col-lg-4 col-md-3">
                    <h5 class="widget-title wow fadeIn animated">About</h5>
                    <ul class="footer-list wow fadeIn animated mb-sm-5 mb-md-0">
                        <li><a href="{{ route('about_us') }}">About Us</a></li>
                        <li><a href="{{ route('faq') }}">FAQs</a></li>
                        <li><a href="{{ url('terms') }}">Terms &amp; Conditions</a></li>
                        <li><a href="{{ route('contacts') }}">Contact Us</a></li>
                        <li><a href="{{ route('contacts') }}">Support Center</a></li>
                    </ul>
                </div>
                <div class="col-lg-4  col-md-3">
                    <h5 class="widget-title wow fadeIn animated">My Account</h5>
                    <ul class="footer-list wow fadeIn animated">
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
<div class="container py-4 wow fadeIn footer-bottom" data-wow-delay="0.3s">
  <div class="row align-items-center">
    <div class="col-12">
      <hr class="border-1 border-warning opacity-25 mb-3">
    </div>
    <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
     <p class="mb-0 font-sm text-muted">
  &copy; {{ date('Y') }} {{ get_option('site_name') }}. All Rights Reserved.
</p>

    </div>
    <div class="col-md-6 text-center text-md-end d-flex flex-column align-items-center align-items-md-end gap-2">
      <div class="footer-payments text-muted small">
        <i class="fab fa-cc-visa"></i>
        <i class="fab fa-cc-mastercard"></i>
        <i class="fab fa-cc-paypal"></i>
      </div>
      <ul class="list-inline mb-0">
        <li class="list-inline-item">
          <a href="#" class="text-info hover-warning">Privacy Policy</a>
        </li>
        <li class="list-inline-item">
          <a href="#" class="text-info hover-warning">Terms of Use</a>
        </li>
        <li class="list-inline-item">
          <a href="#" class="text-info hover-warning">Contact Us</a>
        </li>
      </ul>
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
        @include('theme.electro.bootstrap.inline_js')
    </script>
    <!-- Only keep what we use -->
    <script src="{{ url('/') }}/lucare/assets/js/plugins/slick.js"></script>

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

<style>
/* Footer theme override */
footer.footer-modern{
  background-color:#0A1330;
  color:#e6e9f2;
  /* Comfortable spacing above and inside footer */
  margin-top: clamp(16px, 2.5vw, 40px);
  padding-top: clamp(16px, 3vw, 32px);
}
footer.footer-modern a{color:#dbe2ff;}
footer.footer-modern a:hover{color:#ffffff;}
footer.footer-modern .widget-title,
footer.footer-modern h5,
footer.footer-modern strong{color:#ffffff;}
footer.footer-modern .footer-bottom hr{border-color:rgba(255,255,255,.2)!important;}
/* Make the top chip strip dark-friendly */
footer.footer-modern .footer-top-chips{background:#0A1330;}
footer.footer-modern .footer-top-chips .chip{
  background:#ffffff !important;
  border-color:#e5e7eb !important;
  color:#0A1330 !important;
  font-weight:700;
  box-shadow:0 2px 6px rgba(0,0,0,.08);
}
footer.footer-modern .footer-top-chips .chip span{color:#0A1330 !important; opacity:1;}
footer.footer-modern .footer-top-chips .chip i{color:#ffb020;}

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
@include('chat_widget')
</body>

</html>
