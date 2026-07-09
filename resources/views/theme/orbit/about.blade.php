@extends('theme.orbit.layouts.main')
@section('title', 'About ' . get_option('site_name', 'Orbitlink Solutions'))
@section('meta_description', trim(strip_tags((string) get_option('contact_description'))) ?: ('Learn more about ' . get_option('site_name', 'Orbitlink Solutions') . ' and our networking solutions in Kenya.'))

@push('meta')
    <meta property="og:title" content="About {{ get_option('site_name', 'Orbitlink Solutions') }}" />
    <meta property="og:description" content="{{ trim(strip_tags((string) get_option('contact_description'))) ?: ('Learn more about ' . get_option('site_name', 'Orbitlink Solutions') . ' and our networking solutions in Kenya.') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta name="twitter:card" content="summary_large_image" />
@endpush

@section('main')

<!-- Hero / Intro -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h1 class="mb-2">About {{ get_option('site_name', 'Orbitlink Solutions') }}</h1>
                <p class="lead mb-0">Kenya's partner for networking, Starlink, CCTV, and reliable connectivity.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ url('shop') }}" class="btn btn-accent me-2">Shop Now</a>
                <a href="{{ route('contacts') }}" class="btn btn-outline-secondary">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section id="homepage-description">
    <div class="container">
        <p>Orbitlink Solutions helps homes, SMEs, and enterprise teams build reliable networks across Kenya. We supply and install Starlink kits, WiFi coverage, CCTV surveillance, routers, access points, and structured cabling with end-to-end support.</p>
        <p>From a single router upgrade to full multi-site rollouts, we focus on stable performance, clean installs, and fast support.</p>

        <h2>Where We Serve</h2>
        <p>We support customers across Kenya with delivery and on-site installation where needed.</p>
        <ul>
            <li><strong>Coverage:</strong> Nairobi and nationwide delivery.</li>
            <li><strong>Support:</strong> Remote troubleshooting and on-site visits when required.</li>
        </ul>

        <h2>What We Do</h2>
        <h3>Starlink and Internet Setup</h3>
        <p>We supply Starlink kits, handle mounting, cabling, router setup, and optimize placement for strong signal.</p>

        <h3>Networking and WiFi</h3>
        <p>Design and installation of MikroTik and Ubiquiti networks, switches, access points, and mesh coverage for homes, offices, and campuses.</p>

        <h3>CCTV and Security</h3>
        <p>IP camera systems, NVR configuration, and remote viewing for reliable monitoring.</p>

        <h3>Structured Cabling</h3>
        <p>Clean cable management, racks, patch panels, and tidy terminations for dependable infrastructure.</p>

        <h2>How We Work</h2>
        <ul>
            <li><strong>Consult:</strong> We learn your space, usage, and budget.</li>
            <li><strong>Design:</strong> We propose a simple, scalable network plan.</li>
            <li><strong>Install:</strong> We deploy, test, and document everything.</li>
            <li><strong>Support:</strong> We provide warranty and post-install support.</li>
        </ul>

        <h2>Why Orbitlink</h2>
        <ul>
            <li><strong>Genuine products:</strong> Trusted brands and verified hardware.</li>
            <li><strong>Expert support:</strong> Fast troubleshooting and clear guidance.</li>
            <li><strong>Delivery and installation:</strong> Kenya-wide delivery and on-site options.</li>
        </ul>

        <h2>Contact</h2>
        <p>Ready to upgrade your connectivity? Talk to our team for advice, pricing, and installation.</p>
        @if(get_option('contact_phone'))
            <p><strong>Phone:</strong> {{ get_option('contact_phone') }}</p>
        @endif
        @if(get_option('contact_email'))
            <p><strong>Email:</strong> {{ get_option('contact_email') }}</p>
        @endif
    </div>
</section>

@endsection
