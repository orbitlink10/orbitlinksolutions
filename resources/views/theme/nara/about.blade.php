@extends('theme.nara.layouts.main')
@section('title') About {{ get_option('site_name') }} @endsection
@section('meta_description', Str::limit(strip_tags(get_option('about')), 160))

@push('meta')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "{{ addslashes(get_option('site_name')) }}",
  "url": "{{ url('/') }}",
  "logo": "{{ get_option('logo') }}",
  "telephone": "{{ preg_replace('/\s+/', '', get_option('contact_phone')) }}",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "{{ addslashes(get_option('address')) }}",
    "addressCountry": "KE"
  }
}
</script>
@endpush

@section('main')
<div class="about-page">
    <!-- Hero -->
    <section class="about-hero" style="--hero-image: url('{{ get_option('hero_image') }}');">
        <div class="container">
            <div class="row align-items-end gy-4">
                <div class="col-lg-8">
                    <span class="about-hero-eyebrow about-reveal" style="--delay: .05s;">Our Story</span>
                    <h1 class="about-hero-title about-reveal" style="--delay: .12s;">About {{ get_option('site_name') }}</h1>
                    <p class="about-hero-lead about-reveal" style="--delay: .2s;">We bring together curated products, fast delivery, and reliable support for every order.</p>
                    <div class="about-hero-actions about-reveal" style="--delay: .28s;">
                        <a href="{{ route('contacts') }}" class="btn about-btn">Contact Us</a>
                        <a href="{{ url('shop') }}" class="btn about-btn about-btn-ghost">Shop Now</a>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <nav aria-label="breadcrumb" class="about-reveal" style="--delay: .18s;">
                        <ol class="breadcrumb justify-content-lg-end mb-3">
                            <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active text-white-50" aria-current="page">About</li>
                        </ol>
                    </nav>
                    <div class="about-hero-badge about-reveal" style="--delay: .34s;">
                        <div class="about-hero-badge-label">Trusted by</div>
                        <div class="about-hero-badge-value">{{ number_format((int) get_option('customers_served', 1500)) }}+ customers</div>
                        <div class="about-hero-badge-sub">Across Kenya and beyond</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="about-hero-wave" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" preserveAspectRatio="none" class="d-block" style="width:100%;height:70px"><path fill="#f7f3ee" d="M0,64L80,58.7C160,53,320,43,480,69.3C640,96,800,160,960,170.7C1120,181,1280,139,1360,117.3L1440,96L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path></svg>
        </div>
    </section>

    <!-- About + Sidebar -->
    <section class="section-padding about-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 wow fadeIn animated about-card about-story">
                        <div class="card-body p-4 p-lg-5">
                            <div class="about-kicker">Who we are</div>
                            {!! get_option('about', '<p>Welcome to our website. Learn more about our services and company.</p>') !!}
                        </div>
                    </div>

                    <!-- Why Choose Us -->
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-2">
                        <div>
                            <h4 class="about-section-title mb-1">Why customers choose us</h4>
                            <p class="about-section-sub mb-0">Reliable delivery, authentic products, and real support.</p>
                        </div>
                    </div>
                    <div class="row g-3">
                        @php
                            $features = [
                                ['icon' => 'fi-rs-truck', 'title' => 'Fast Delivery', 'desc' => 'Swift nationwide shipping at a small fee.'],
                                ['icon' => 'fi-rs-shield-check', 'title' => 'Genuine Warranty', 'desc' => 'Quality products backed by warranty.'],
                                ['icon' => 'fi-rs-credit-card', 'title' => 'Secure Payments', 'desc' => 'Trusted gateways and safe checkout.'],
                                ['icon' => 'fi-rs-headset', 'title' => '7-Day Support', 'desc' => 'We are here to help all week.'],
                            ];
                        @endphp
                        @foreach($features as $f)
                        <div class="col-6 col-md-6 col-xl-3">
                            <div class="about-feature-card h-100">
                                <span class="about-feature-icon">
                                    <i class="{{ $f['icon'] }}"></i>
                                </span>
                                <h6 class="mb-1">{{ $f['title'] }}</h6>
                                <p class="text-muted small mb-0">{{ $f['desc'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Stats -->
                    <div class="row text-center mt-4 g-3">
                        @php
                            $stats = [
                                ['num' => (int) get_option('years_experience', 5), 'label' => 'Years Experience'],
                                ['num' => (int) get_option('customers_served', 1500), 'label' => 'Happy Customers'],
                                ['num' => (int) get_option('products_listed', 500), 'label' => 'Products'],
                                ['num' => (int) get_option('orders_fulfilled', 3000), 'label' => 'Orders Fulfilled'],
                            ];
                        @endphp
                        @foreach($stats as $s)
                        <div class="col-6 col-md-3">
                            <div class="about-metric h-100">
                                <div class="about-metric-value">{{ number_format($s['num']) }}+</div>
                                <div class="about-metric-label">{{ $s['label'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Sidebar Card -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm sticky-top about-card about-side-card" style="top:90px">
                        <div class="card-body p-4">
                            <h5 class="fw-600 mb-3">Contact Information</h5>
                            <ul class="list-unstyled mb-4 about-contact-list">
                                <li class="mb-2"><i class="fi-rs-marker"></i><span>{{ get_option('address') }}</span></li>
                                <li class="mb-2"><i class="fi-rs-headset"></i><span>{{ get_option('contact_phone') }}</span></li>
                                <li class="mb-2"><i class="fi-rs-time-quarter"></i><span>Mon-Sat, 9:00-18:00</span></li>
                            </ul>
                            <a href="{{ route('contacts') }}" class="btn about-btn w-100 mb-2">Contact Us</a>
                            <a href="{{ url('shop') }}" class="btn about-btn about-btn-ghost w-100">Shop Now</a>
                            <hr>
                            <div class="small text-muted">We ship nationwide at a small fee. For bulk orders or custom requests, talk to us.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="about-cta">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-lg-8">
                    <h3 class="mb-1">Have a question or special request?</h3>
                    <p class="mb-0 text-muted">Our team is ready to help you choose the right products.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('contacts') }}" class="btn about-btn btn-lg">Get in touch</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('styles')
<style>
    @import url("https://fonts.googleapis.com/css2?family=Fraunces:wght@400;600;700&family=Manrope:wght@400;500;600;700&display=swap");

    .about-page {
        --about-ink: #0f1a2b;
        --about-ink-soft: #2b3a50;
        --about-accent: #f5b73b;
        --about-accent-2: #2fa59b;
        --about-bg: #f7f3ee;
        --about-surface: #ffffff;
        --about-line: #e8e0d4;
        --about-muted: #6b778c;
        font-family: "Manrope", sans-serif;
        color: var(--about-ink);
        background: var(--about-bg);
    }

    .about-hero {
        position: relative;
        color: #f9fbff;
        padding: 72px 0 36px;
        background-image:
            linear-gradient(120deg, rgba(10, 18, 40, 0.92), rgba(10, 18, 40, 0.55)),
            linear-gradient(180deg, rgba(12, 25, 44, 0.75), rgba(12, 25, 44, 0.2)),
            var(--hero-image);
        background-size: cover;
        background-position: center;
        overflow: hidden;
    }

    .about-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            radial-gradient(520px circle at 18% 18%, rgba(245, 183, 59, 0.3), transparent 60%),
            radial-gradient(520px circle at 88% 8%, rgba(47, 165, 155, 0.25), transparent 60%);
        opacity: 0.75;
        pointer-events: none;
    }

    .about-hero .container {
        position: relative;
        z-index: 1;
    }

    .about-hero-eyebrow {
        display: inline-flex;
        padding: 6px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.16);
        font-size: 0.75rem;
        letter-spacing: 0.2em;
        text-transform: uppercase;
    }

    .about-hero-title {
        font-family: "Fraunces", serif;
        font-size: clamp(2.4rem, 3vw + 1rem, 3.6rem);
        font-weight: 700;
        margin: 12px 0 10px;
    }

    .about-hero-lead {
        font-size: 1.1rem;
        max-width: 540px;
        color: rgba(255, 255, 255, 0.82);
    }

    .about-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 24px;
    }

    .about-hero-badge {
        display: inline-flex;
        flex-direction: column;
        gap: 4px;
        padding: 16px 18px;
        border-radius: 16px;
        background: rgba(13, 23, 43, 0.72);
        border: 1px solid rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(8px);
    }

    .about-hero-badge-label {
        font-size: 0.85rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.7);
    }

    .about-hero-badge-value {
        font-size: 1.6rem;
        font-weight: 700;
        font-family: "Fraunces", serif;
    }

    .about-hero-badge-sub {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
    }

    .about-hero-wave {
        position: relative;
        z-index: 1;
    }

    .about-section {
        position: relative;
        background: var(--about-bg);
    }

    .about-section::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 10% 10%, rgba(245, 183, 59, 0.08), transparent 40%);
        pointer-events: none;
        z-index: 0;
    }

    .about-section .container {
        position: relative;
        z-index: 1;
    }

    .about-card {
        border-radius: 18px;
        background: var(--about-surface);
        border: 1px solid var(--about-line);
        box-shadow: 0 24px 50px rgba(15, 26, 43, 0.08);
    }

    .about-story {
        position: relative;
        overflow: hidden;
    }

    .about-story::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 6px;
        background: linear-gradient(180deg, var(--about-accent), rgba(47, 165, 155, 0.6));
    }

    .about-kicker {
        font-size: 0.85rem;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--about-muted);
        margin-bottom: 14px;
    }

    .about-section-title {
        font-family: "Fraunces", serif;
        color: var(--about-ink);
    }

    .about-section-sub {
        color: var(--about-muted);
    }

    .about-feature-card {
        padding: 18px;
        border-radius: 16px;
        border: 1px solid rgba(232, 224, 212, 0.9);
        background: linear-gradient(145deg, #ffffff 0%, #fbf7f1 100%);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .about-feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 32px rgba(15, 26, 43, 0.12);
    }

    .about-feature-icon {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: rgba(245, 183, 59, 0.18);
        color: #cc8b18;
        margin-bottom: 10px;
        font-size: 20px;
    }

    .about-metric {
        padding: 18px 14px;
        border-radius: 16px;
        background: #fff;
        border: 1px dashed rgba(232, 224, 212, 0.9);
    }

    .about-metric-value {
        font-size: 1.6rem;
        font-weight: 700;
        font-family: "Fraunces", serif;
        color: var(--about-ink);
    }

    .about-metric-label {
        font-size: 0.85rem;
        color: var(--about-muted);
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .about-contact-list li {
        display: flex;
        gap: 10px;
        color: var(--about-ink-soft);
    }

    .about-contact-list i {
        color: var(--about-accent-2);
        margin-top: 2px;
    }

    .about-side-card {
        background: linear-gradient(160deg, #ffffff 0%, #fbf5ea 100%);
    }

    .about-cta {
        position: relative;
        padding: 56px 0;
        background: linear-gradient(120deg, #fef1db 0%, #e6f7f4 100%);
        overflow: hidden;
    }

    .about-cta::before {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(500px circle at 80% 20%, rgba(47, 165, 155, 0.25), transparent 60%);
        pointer-events: none;
    }

    .about-cta .container {
        position: relative;
        z-index: 1;
    }

    .about-btn {
        background: var(--about-accent);
        border: 1px solid transparent;
        color: #1f1a10;
        font-weight: 600;
        border-radius: 999px;
        padding: 0.65rem 1.6rem;
        box-shadow: 0 12px 20px rgba(245, 183, 59, 0.25);
    }

    .about-btn:hover {
        background: #f0a922;
        color: #1f1a10;
    }

    .about-btn-ghost {
        background: transparent;
        border-color: rgba(15, 26, 43, 0.25);
        color: var(--about-ink);
        box-shadow: none;
    }

    .about-hero .about-btn-ghost {
        border-color: rgba(255, 255, 255, 0.45);
        color: #ffffff;
    }

    .about-reveal {
        opacity: 0;
        animation: about-fade-up 0.8s ease forwards;
        animation-delay: var(--delay, 0s);
    }

    @keyframes about-fade-up {
        from {
            opacity: 0;
            transform: translateY(14px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 991px) {
        .about-hero {
            padding: 56px 0 28px;
        }

        .about-hero-badge {
            align-items: flex-start;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .about-reveal {
            animation: none;
            opacity: 1;
        }

        .about-feature-card {
            transition: none;
        }
    }
</style>
@endsection
