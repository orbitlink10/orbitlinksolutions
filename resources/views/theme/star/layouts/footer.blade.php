<section class="py-5" id="contact" style="background: linear-gradient(180deg, #000, #333); color: #fff;">
  <div class="container">
    <div class="row gy-4">
      <!-- Contact Information -->
      <div class="col-12 col-sm-4">
        <h3 class="lh-lg fw-bold text-light mb-3">Need Assistance?</h3>
        <p class="mb-2">If you have questions, please contact us:</p>
        <p class="mb-1">Email: <a href="mailto:{{get_option('contact_email')}}" style="color: #fff; text-decoration: none;">{{get_option('contact_email') }}</a></p>
        <p class="mb-1">Phone: <a href="tel:{{get_option('contact_phone')}}" style="color: #fff; text-decoration: none;">{{get_option('contact_phone') }}</a></p>
        <p>Best hours: 9AM-5PM EAT Mon-Sat</p>
      </div>

      <!-- Menu Links -->
      <div class="col-12 col-sm-4">
        <h5 class="lh-lg fw-bold text-light mb-3">Menu</h5>
        <ul class="list-unstyled">
          <li class="lh-lg"><a class="text-decoration-none text-uppercase fw-bold hover-underline" style="color: #fff;" href="{{ url('shop') }}">Shop</a></li>
          <li class="lh-lg"><a class="text-decoration-none text-uppercase fw-bold hover-underline" style="color: #fff;" href="{{ route('about_us') }}">About Us</a></li>
          <li class="lh-lg"><a class="text-decoration-none text-uppercase fw-bold hover-underline" style="color: #fff;" href="{{ route('faq') }}">FAQs</a></li>
        </ul>
      </div>

      <!-- Contact Links -->
      <div class="col-12 col-sm-4">
        <h5 class="lh-lg fw-bold text-light mb-3">Contact</h5>
        <ul class="list-unstyled">
          <li class="lh-lg"><a class="text-decoration-none text-uppercase fw-bold hover-underline" style="color: #fff;" href="{{ route('contacts') }}">Contact Us</a></li>

          <li class="lh-lg"><a class="text-decoration-none text-uppercase fw-bold hover-underline" style="color: #fff;" href="{{ url('working-hours') }}">Working Hours</a></li>


        <li class="lh-lg"><a class="text-decoration-none text-uppercase fw-bold hover-underline" style="color: #fff;" href="{{ url('terms') }}">Terms and Conditions</a>
        </li>


        </ul>
      </div>
    </div>

    <hr class="border-light opacity-50 my-4">
    <div class="row flex-center text-center text-md-start gy-3">
      <div class="col-md-6">
        <p class="mb-0" style="color: #fff;">
          © 2024 {{ get_option('site_name') }}. All Rights Reserved</a>
        </p>
      </div>

      <!-- Social Media Icons -->
      <div class="col-md-6 text-md-end">
        <a href="{{ get_option('facebook') }}" class="btn btn-outline-light btn-sm rounded-circle me-2"><i class="fab fa-facebook-f"></i></a>
        <a href="{{ get_option('instagram') }}" class="btn btn-outline-light btn-sm rounded-circle me-2"><i class="fab fa-instagram"></i></a>
        <a href="{{ get_option('twitter') }}" class="btn btn-outline-light btn-sm rounded-circle"><i class="fab fa-twitter"></i></a>
      </div>
    </div>
  </div>
</section>

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
 