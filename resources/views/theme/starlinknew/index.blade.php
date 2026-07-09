@extends('theme.starlinknew.layouts.main')

{{-- Page Title & Meta --}}

@section('title', Cache::remember('starlink_hero_title', 3600, fn() => get_option('hero_header_title')))
@section('meta_description', Cache::remember('starlink_hero_desc', 3600, fn() => get_option('hero_header_description')))




@section('main')
@php
  // Cache dynamic options
  $heroTitle         = Cache::remember('spacelink_hero_title', 3600, fn() =>
                          get_option('hero_header_title', 'Spacelink Kenya: Your Gateway to High-Speed Satellite Internet')
                       );
  $heroDesc          = Cache::remember('spacelink_hero_desc', 3600, fn() =>
                          get_option('hero_header_description', 'Purchase genuine Starlink Kenya kits and enjoy expert installation across Kenya. Reliable satellite internet for homes and businesses.')
                       );
  $heroImage         = Cache::remember('spacelink_hero_img', 3600, fn() =>
                          get_option('hero_image', asset('assets/img/spacelink-hero.jpg'))
                       );
  $cachedProducts    = Cache::remember('starlink_products',    3600, fn() => $products);
  $cachedMedias2     = Cache::remember('starlink_medias2',     3600, fn() => $medias2);
  $cachedTestimonials= Cache::remember('starlink_testimonials',3600, fn() => $testimonials);
  $cachedServices    = Cache::remember('starlink_services',    3600, fn() => $services);
@endphp

<!--=== Header ===-->
<section id="header" class="section-py position-relative bg-light">
  <div class="bg-holder position-absolute w-100 h-100"
       style="background-image:url({{ asset('assets/img/gallery/header-bg-light.png') }}); background-position:right top; background-size:cover;"
       aria-hidden="true"></div>
  <div class="container">
    <div class="row align-items-center min-vh-75">
      <div class="col-md-6 text-md-start text-center mb-4 mb-md-0">
        <span class="badge bg-primary bg-opacity-10 text-primary mb-3 rounded-pill px-3 py-2">
          Welcome to Starlite Internet Kenya
        </span>
        <h1 class="display-4 fw-bold text-dark mb-3">
          {!! $heroTitle !!} <span class="text-gradient">Kenya</span>
        </h1>
        <p class="lead text-secondary mb-4">{!! $heroDesc !!}</p>
        <div class="d-grid gap-2 d-sm-flex">
          <a href="{{ url('shop') }}" class="btn btn-primary shadow" rel="preload">Shop Now</a>
          <a href="{{ route('contacts') }}" class="btn btn-outline-primary shadow" rel="preload">Talk to an Expert</a>
        </div>
        <div class="d-flex gap-4 mt-5">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill text-primary"></i><span>Fast Setup</span>
          </div>
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill text-primary"></i><span>24/7 Support</span>
          </div>
        </div>
      </div>
      <div class="col-md-6 text-center">
        <img src="{{ $heroImage }}" alt="Spacelink Kenya Hero"
             class="img-fluid rounded-4 shadow floating"
             loading="lazy"
             style="max-width:90%;">
      </div>
    </div>
  </div>
</section>

<!--=== Products ===-->
<section id="products" class="py-5 bg-light">
  <div class="container">
    <div class="row mb-5">
      <div class="col-lg-7 text-center text-lg-start">
        <h2 class="fw-bold mb-3">Our <span class="text-gradient">Starlink Kenya Kits</span></h2>
        <p class="text-muted">Explore our genuine Starlink hardware and accessories.</p>
      </div>
    </div>
    <div class="row g-4">
      @foreach($cachedProducts as $product)
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card h-100 shadow-sm border-0">
            <img src="{{ url('/') }}/storage/{{ $product->photo }}"
                 alt="{{ $product->name }}"
                 class="card-img-top"
                 loading="lazy"
                 style="height:200px; object-fit:cover;">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title text-truncate">{{ Str::limit($product->name, 30) }}</h5>
              <div class="d-flex justify-content-between align-items-center mt-auto">
                @if($product->has_price)
                  <span class="fw-semibold">KES {{ number_format($product->price,2) }}</span>
                @endif
                <a href="{{ route('product_details', $product->slug) }}" class="btn btn-sm btn-primary">View</a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>



<!--=== Careers ===-->
<!--=== Careers (Advanced UI) ===-->
<section id="careers" class="section-py bg-white">
  <div class="container">
    <div class="row gy-5">
      <!-- Job Cards -->
      <div class="col-lg-6">
        <h2 class="fw-bold mb-4">Join Our Team</h2>
        <div class="row g-4">
          @php
            $jobs = [
              [
                'title' => 'Satellite Installation Technician',
                'icon'  => 'bi-satellite-fill',
                'desc'  => 'Install & align satellite dishes for optimal connectivity.'
              ],
              [
                'title' => 'Customer Support Specialist',
                'icon'  => 'bi-headset',
                'desc'  => 'Provide 24/7 support to our Kenyan customer base.'
              ],
              [
                'title' => 'Digital Marketer',
                'icon'  => 'bi-megaphone-fill',
                'desc'  => 'Drive our online presence across social & search channels.'
              ],
            ];
          @endphp

          @foreach($jobs as $job)
            <div class="col-12">
              <div class="card h-100 border-0 shadow-sm hover-lift" data-job-title="{{ $job['title'] }}">
                <div class="card-body d-flex">
                  <div class="me-4">
                    <i class="bi {{ $job['icon'] }} fs-1 text-primary"></i>
                  </div>
                  <div class="flex-grow-1">
                    <h5 class="card-title">{{ $job['title'] }}</h5>
                    <p class="card-text text-muted">{{ $job['desc'] }}</p>
                  </div>
                  <div class="align-self-center">
                    <button class="btn btn-outline-primary apply-btn">Apply</button>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <!-- Application Form -->
      <div class="col-lg-6">
        <h2 class="fw-bold mb-4">Apply Now</h2>
        <div class="card border-0 shadow-sm p-4">
          <form id="careerForm" action="{{ route('careers.apply') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="form-floating mb-3">
              <input type="text" name="name" class="form-control" id="applicantName" placeholder="Full Name" required>
              <label for="applicantName">Full Name</label>
              <div class="invalid-feedback">Please enter your full name.</div>
            </div>

            <div class="form-floating mb-3">
              <input type="email" name="email" class="form-control" id="applicantEmail" placeholder="name@example.com" required>
              <label for="applicantEmail">Email Address</label>
              <div class="invalid-feedback">Please enter a valid email.</div>
            </div>

            <div class="form-floating mb-3">
              <select name="position" id="jobPosition" class="form-select" required>
                <option value="" disabled selected>Choose a position</option>
                @foreach($jobs as $job)
                  <option>{{ $job['title'] }}</option>
                @endforeach
              </select>
              <label for="jobPosition">Position</label>
              <div class="invalid-feedback">Please select a position.</div>
            </div>

            <div class="mb-3">
              <label for="resumeUpload" class="form-label">Upload Resume (PDF)</label>
              <input type="file" name="resume" class="form-control" id="resumeUpload" accept=".pdf" required>
              <div class="invalid-feedback">Please upload your resume in PDF format.</div>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary btn-lg">Submit Application</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Styles for hover effect -->
  <style>
    .hover-lift {
      transition: transform .2s, box-shadow .2s;
    }
    .hover-lift:hover {
      transform: translateY(-4px);
      box-shadow: 0 0.75rem 1.5rem rgba(0,0,0,0.1);
    }
  </style>
</section>

@push('scripts')
<script>
  // Bootstrap custom validation
  (() => {
    'use strict';
    const form = document.getElementById('careerForm');
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  })();

  // Scroll to form and pre-select position
  document.querySelectorAll('.apply-btn').forEach(btn => {
    btn.addEventListener('click', e => {
      const jobTitle = e.currentTarget.closest('.card').dataset.jobTitle;
      document.getElementById('jobPosition').value = jobTitle;
      document.getElementById('jobPosition').dispatchEvent(new Event('change'));
      document.getElementById('applicantName').focus();
      document.getElementById('careerForm').scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });
</script>
@endpush




<!--=== Overview ===-->
<section id="overview" class="section-py bg-white">
  <div class="container">
    <div class="row align-items-center gy-5">
      <div class="col-lg-6">
        <h2 class="fw-bold mb-4">Discover <span class="text-gradient">Starlink Kenya</span></h2>
        <p class="lead text-muted mb-4">
          Cutting-edge Starlink Kenya satellite internet with local expertise—reliable, low-latency connectivity across all of Kenya.
        </p>
        <ul class="list-unstyled">
          <li class="d-flex mb-3"><i class="bi bi-check2 text-primary me-3"></i>Speeds up to 220 Mbps</li>
          <li class="d-flex mb-3"><i class="bi bi-check2 text-primary me-3"></i>Optimized for Kenyan terrain</li>
          <li class="d-flex"><i class="bi bi-check2 text-primary me-3"></i>DIY or Pro install</li>
        </ul>
        <a href="#contact" class="btn btn-primary mt-3">Get Started</a>
      </div>
      <div class="col-lg-6">
        <div class="ratio ratio-16x9 rounded-4 shadow overflow-hidden">
          <iframe src="https://www.youtube.com/embed/ZBpsEnxmsG4"
                  title="Starlink Kenya Intro"
                  allowfullscreen
                  loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </div>
</section>

<!--=== Features ===-->
<section id="features" class="section-py bg-light">
  <div class="container">
    <h2 class="text-center fw-bold mb-5">Why Choose <span class="text-gradient">Starlink Kenya</span>?</h2>
    <div class="row g-4">
      @foreach([
        ['icon'=>'award',       'title'=>'Official Reseller',        'text'=>'Authentic hardware & service'],
        ['icon'=>'truck',       'title'=>'Local Delivery',           'text'=>'Fast dispatch from Nairobi'],
        ['icon'=>'tools',       'title'=>'Certified Installation',   'text'=>'Perfect dish alignment'],
        ['icon'=>'wallet2',     'title'=>'Flexible Payments',        'text'=>'Monthly plans & financing'],
        ['icon'=>'shield-check','title'=>'Warranty',                 'text'=>'12-month guarantee'],
        ['icon'=>'headset',     'title'=>'24/7 Support',             'text'=>'Kenya-based team']
      ] as $item)
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm text-center p-4">
            <i class="bi bi-{{ $item['icon'] }} fs-1 text-primary mb-3"></i>
            <h5>{{ $item['title'] }}</h5>
            <p class="text-muted mb-0">{{ $item['text'] }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!--=== Extensions ===-->
<section id="extensions" class="section-py bg-white">
  <div class="container">
    <div class="text-center mb-5">
      <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mb-3">Our Solutions</span>
      <h2 class="fw-bold mb-3">Starlink <span class="text-gradient">Extensions</span></h2>
      <p class="lead text-muted mx-auto" style="max-width:700px;">
        Scale your Starlink Kenya footprint with official extension kits and network design—ideal for estates, communities, and tough terrain.
      </p>
    </div>
    <div class="row g-4">
      @foreach([
        ['icon'=>'satellite','title'=>'Additional Dish Units','text'=>'Cover multiple buildings or zones.'],
        ['icon'=>'broadcast-pin','title'=>'Signal Boosters',     'text'=>'Push connectivity deeper into valleys.'],
        ['icon'=>'diagram-3',     'title'=>'Mesh Integration',     'text'=>'Site-wide Wi-Fi mesh networks.']
      ] as $item)
        <div class="col-sm-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm text-center p-4">
            <i class="bi bi-{{ $item['icon'] }} fs-1 text-primary mb-3"></i>
            <h5>{{ $item['title'] }}</h5>
            <p class="text-muted">{{ $item['text'] }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!--=== Recent Installations ===-->
@if($cachedMedias2->count())
<section id="installations" class="section-py bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mb-3">Our Work</span>
      <h2 class="fw-bold mb-3">Recent <span class="text-gradient">Installations</span></h2>
      <p class="lead text-muted mx-auto" style="max-width:700px;">
        See our latest Starlink Kenya setups across the country.
      </p>
    </div>
    <div id="installationsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
      <div class="carousel-inner">
        @foreach($cachedMedias2->chunk(4) as $i => $chunk)
          <div class="carousel-item @if($i===0) active @endif">
            <div class="row g-4">
              @foreach($chunk as $media)
                <div class="col-md-3">
                  <div class="card border-0" data-bs-toggle="modal" data-bs-target="#imageModal2" onclick="showImagea('{{ $media->file_path }}')">
                    <img src="{{ $media->file_path }}" class="w-100 rounded-3" alt="Installation" loading="lazy">
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endforeach
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#installationsCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-primary rounded-circle p-3"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#installationsCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-primary rounded-circle p-3"></span>
      </button>
    </div>
  </div>
</section>
<div class="modal fade" id="imageModal2" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0">
      <div class="modal-body text-center p-0">
        <img id="modalImage2" src="" class="img-fluid rounded" alt="Full View">
      </div>
    </div>
  </div>
</div>
@endif

<!--=== Testimonials ===-->
<section id="testimonials" class="section-py bg-white">
  <div class="container">
    <div class="text-center mb-5">
      <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mb-3">Testimonials</span>
      <h2 class="fw-bold mb-3">What Our <span class="text-gradient">Clients</span> Say</h2>
    </div>
    <div id="testimonialsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
      <div class="carousel-inner">
        @foreach($cachedTestimonials->chunk(3) as $i => $chunk)
          <div class="carousel-item @if($i===0) active @endif">
            <div class="row g-4">
              @foreach($chunk as $t)
                <div class="col-md-4">
                  <div class="card border-0 shadow-sm p-4 h-100 text-center">
                    <i class="bi bi-quote fs-1 text-primary mb-3"></i>
                    <p class="fst-italic">"{{ $t->description }}"</p>
                    <h6 class="mt-3">{{ $t->name }}</h6>
                    <small class="text-muted">Customer</small>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endforeach
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-primary rounded-circle p-3"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-primary rounded-circle p-3"></span>
      </button>
    </div>
  </div>
</section>

<!--=== Services ===-->
<section id="services" class="section-py bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mb-3">Our Services</span>
      <h2 class="fw-bold mb-3">Explore Our <span class="text-gradient">Starlink Kenya</span> Solutions</h2>
    </div>
    <div class="row g-4">
      @foreach($cachedServices as $service)
        <div class="col-sm-6 col-md-4 d-flex">
          <div class="card h-100 border-0 shadow-sm">
            @if($service->image_url)
              <img src="{{ $service->image_url }}" alt="{{ $service->name }}"
                   class="card-img-top" loading="lazy"
                   style="height:180px; object-fit:cover;">
            @endif
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{ $service->name }}</h5>
              <p class="card-text text-muted flex-grow-1">{!! $service->meta_description ?? '' !!}</p>
              <a href="{{ route('service_single', $service->slug ?? '0') }}"
                 class="btn btn-primary mt-auto">Learn More</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!--=== Homepage Description ===-->
<section id="homepage-description" class="section-py bg-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4">
          <div class="card-body p-5">
            <h2 class="fw-bold mb-4">About Spacelink Kenya</h2>
            <p>
              At <strong>Spacelink Kenya</strong>, we’re on a mission to connect every corner of the country with reliable,
              high-speed satellite internet. As the authorized provider of genuine <strong>Starlink Kenya</strong> kits,
              our team combines deep technical expertise with local know-how to deliver end-to-end service—from hardware
              procurement and delivery to professional on-site installation and ongoing support.
            </p>
            <h4 class="mt-4">Our Commitment</h4>
            <ul class="list-unstyled mb-4">
              <li class="d-flex mb-2"><i class="bi bi-check2 text-primary me-2"></i>Nationwide Coverage & Local Support</li>
              <li class="d-flex mb-2"><i class="bi bi-check2 text-primary me-2"></i>Transparent Pricing & No Hidden Fees</li>
              <li class="d-flex mb-2"><i class="bi bi-check2 text-primary me-2"></i>Satisfaction Warranty & Signal Testing On-Site</li>
            </ul>
            <h4 class="mt-4">Get Online, Stay Online</h4>
            <p>
              Whether you’re in Nairobi’s CBD or a remote homestead in Turkana, <strong>Spacelink Kenya</strong> brings the
              power of <strong>Starlink Kenya</strong>—ultra-low latency and gigabit-class speeds—to your doorstep.
              Ready to transform your connectivity?
            </p>
            <a href="{{ url('shop') }}" class="btn btn-primary mt-3">Order Your Kit Now</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

 <!--=== Homepage Description ===-->
<section id="homepage-description" class="section-py bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 position-relative">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-5 description-frame sticky-description" id="scrollable-description">
                        {!! get_option('homepage_description') !!}
                    </div>
                </div>
                <!-- Gradient fade -->
                <div class="scroll-fade"></div>
                <!-- Clickable arrow -->
                <div class="scroll-arrow text-center" id="scroll-arrow">
                    <i class="bi bi-chevron-double-down"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .description-frame {
        max-height: 500px;
        overflow-y: auto;
        border-radius: 16px;
        border: 1px solid #eaeaea;
        background: #fff;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
        padding: 2rem;
        scroll-behavior: smooth;
        position: relative;
    }

    .sticky-description {
        position: sticky;
        top: 100px;
    }

    .scroll-fade {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 60px;
        background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, #ffffff 100%);
        border-radius: 0 0 16px 16px;
        pointer-events: none;
        z-index: 10;
    }

    .scroll-arrow {
        position: absolute;
        bottom: 15px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 1.5rem;
        color: #003366;
        cursor: pointer;
        animation: bounce 2s infinite;
        z-index: 20;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {transform: translate(-50%, 0);}
        40% {transform: translate(-50%, -8px);}
        60% {transform: translate(-50%, -4px);}
    }

    .description-frame::-webkit-scrollbar {
        width: 8px;
    }

    .description-frame::-webkit-scrollbar-thumb {
        background: #003366;
        border-radius: 4px;
    }

    @media (max-width: 768px) {
        .description-frame {
            max-height: 400px;
            padding: 1.5rem;
        }

        .sticky-description {
            top: 60px;
        }

        .scroll-arrow {
            font-size: 1.2rem;
            bottom: 10px;
        }
    }
</style>

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
          crossorigin="anonymous">
  </script>
  <script>
    function showImage(src) {
      document.getElementById('modalImage').src = src;
    }
    function showImagea(src) {
      document.getElementById('modalImage2').src = src;
    }

    document.addEventListener('DOMContentLoaded', function() {
      // Initialize tooltips
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.map(el => new bootstrap.Tooltip(el));

      // Animate on scroll
      const animateOnScroll = () => {
        document.querySelectorAll('.card-hover, .highlight-box').forEach(el => {
          const pos = el.getBoundingClientRect().top;
          if (pos < window.innerHeight / 1.2) {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
          }
        });
      };
      window.addEventListener('load', animateOnScroll);
      window.addEventListener('scroll', animateOnScroll);
    });
  </script>
@endpush
@endsection
