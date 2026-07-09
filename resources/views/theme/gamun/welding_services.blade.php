@extends('theme.gamun.layouts.main')
@section('title', 'Onsite Welding Services | Kenya-wide')
@section('meta_description', 'Professional onsite welding services across Kenya. Repairs, fabrication, gates, grills, frames. Same-day response, certified welders, quality guaranteed.')

@push('meta')
@php
  $siteName = get_option('site_name');
  $phone = get_option('contact_phone');
  $serviceSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'name' => 'Onsite Welding Service',
    'provider' => [ '@type' => 'LocalBusiness', 'name' => $siteName ],
    'areaServed' => 'KE',
    'description' => 'Mobile welding for repairs, fabrication and installations with same-day response.',
    'telephone' => $phone,
    'serviceType' => 'Welding',
  ];
@endphp
<script type="application/ld+json">@json($serviceSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)</script>
@endpush

@section('main')

@php
  $rawPhone = get_option('contact_phone');
  $wa = preg_replace('/\D+/', '', $rawPhone ?? '');
  if (\Illuminate\Support\Str::startsWith($wa, '0')) { $wa = '254'.\Illuminate\Support\Str::substr($wa, 1); }
  $waMsg = urlencode("Hi, I'd like to book an onsite welding service.");
  $waLink = $wa ? "https://wa.me/{$wa}?text={$waMsg}" : null;
  $heroImg = get_option('hero_image') ?: get_option('logo');
@endphp

<section class="section-padding">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-7">
        <h1 class="display-6 fw-bold mb-2">Onsite Welding Services</h1>
        <p class="lead text-secondary mb-3">Repairs, fabrication and installations — we come to you with the right tools and expertise.</p>
        <ul class="text-muted mb-4">
          <li>Same-day response in major towns</li>
          <li>ARC, MIG and TIG depending on job</li>
          <li>Gates, grills, frames, hinges, rails, trailers and more</li>
        </ul>
        <div class="d-flex flex-wrap gap-2">
          <a href="#booking" class="btn btn-primary btn-lg rounded-pill px-4"><i class="fas fa-calendar-check me-2"></i>Book Now</a>
          @if($waLink)
            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-success btn-lg rounded-pill px-4 d-inline-flex align-items-center"><i class="fab fa-whatsapp me-2"></i>WhatsApp</a>
          @endif
        </div>
      </div>
      <div class="col-lg-5">
        <div class="ratio ratio-4x3 rounded" style="background:url('{{ $heroImg }}') center/cover no-repeat"></div>
      </div>
    </div>
  </div>
  </section>

<!-- Pricing / Packages -->
<section class="section-padding pt-0">
  <div class="container">
    <h2 class="h4 fw-bold mb-3 text-center">Transparent Pricing</h2>
    <p class="text-muted text-center mb-4">Fair rates with workmanship guarantee. Materials priced separately.</p>
    <div class="row g-3 g-lg-4">
      <div class="col-md-4">
        <div class="card h-100 text-center py-3">
          <div class="card-body">
            <h3 class="h5">Repair Visit</h3>
            <p class="text-muted">Minor repairs and adjustments</p>
            <div class="display-6 text-brand mb-2">KSh 3,500</div>
            <ul class="list-unstyled small text-muted mb-3">
              <li>Up to 1.5 hours onsite</li>
              <li>Call-out and labour included</li>
            </ul>
            <a href="#booking" class="btn btn-outline-primary rounded-pill">Book Repair</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 text-center py-3 border-primary" style="box-shadow: 0 10px 24px rgba(13,110,253,.1)">
          <div class="card-body">
            <h3 class="h5">Fabrication</h3>
            <p class="text-muted">Gates, grills, frames and custom</p>
            <div class="display-6 text-brand mb-2">From KSh 7,500</div>
            <ul class="list-unstyled small text-muted mb-3">
              <li>Site assessment & quote</li>
              <li>Materials billed separately</li>
            </ul>
            <a href="#booking" class="btn btn-primary rounded-pill">Get a Quote</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 text-center py-3">
          <div class="card-body">
            <h3 class="h5">Emergency</h3>
            <p class="text-muted">Urgent onsite response</p>
            <div class="display-6 text-brand mb-2">Call for rates</div>
            <ul class="list-unstyled small text-muted mb-3">
              <li>Priority dispatch</li>
              <li>24/7 availability</li>
            </ul>
            @if($waLink)
              <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-outline-success rounded-pill">WhatsApp Now</a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Booking form -->
<section id="booking" class="section-padding pt-0">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-6">
        <h2 class="h4 fw-bold mb-2">Book a Welder</h2>
        <p class="text-muted">Fill in your details and we will confirm schedule and pricing.</p>
        <form action="{{ route('save_message') }}" method="POST" class="mt-3">
          @csrf
          <input type="hidden" name="subject" value="Onsite Welding Booking">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Phone</label>
              <input type="tel" name="phone" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Location</label>
              <input type="text" name="location" class="form-control" placeholder="Estate / Town">
            </div>
            <div class="col-12">
              <label class="form-label">Service Needed</label>
              <select name="service" class="form-select">
                <option>Repair</option>
                <option>Fabrication</option>
                <option>Installation</option>
                <option>Other</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Details</label>
              <textarea name="message" rows="5" class="form-control" placeholder="Describe the job (what, where, sizes, photos link if any)" required></textarea>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4">Submit Request</button>
              @if($waLink)
                <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-outline-success btn-lg rounded-pill px-4 ms-2">WhatsApp</a>
              @endif
            </div>
          </div>
        </form>
      </div>
      <div class="col-lg-6">
        <div class="p-4 p-lg-5 bg-white rounded" style="border:1px solid var(--border); box-shadow: var(--shadow-sm)">
          <h3 class="h5 fw-bold mb-3">Why Choose {{ get_option('site_name') }}?</h3>
          <ul class="list-unstyled text-muted mb-4">
            <li class="mb-2"><i class="fas fa-user-check text-primary me-2"></i>Certified and experienced welders</li>
            <li class="mb-2"><i class="fas fa-bolt text-primary me-2"></i>Fast scheduling & dependable arrival</li>
            <li class="mb-2"><i class="fas fa-shield-alt text-primary me-2"></i>Safe, clean and guaranteed workmanship</li>
            <li class="mb-2"><i class="fas fa-wallet text-primary me-2"></i>Clear pricing with no surprises</li>
          </ul>
          <div class="small text-muted">We bring portable equipment and can work in residential, commercial or remote sites. For larger fabrication, we combine onsite fitting with workshop prep to save time.</div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

