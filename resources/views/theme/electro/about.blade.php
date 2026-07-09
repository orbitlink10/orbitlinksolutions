@extends('theme.electro.layouts.main')
@section('title', 'About MK Homestyles')
@section('meta_description', 'MK Homestyles — your one‑stop shop in Kenya for solar, power backup, lighting, surveillance, tools and installation services with nationwide delivery.')

@push('meta')
    <link rel="canonical" href="{{ url()->current() }}" />
    <meta property="og:title" content="About MK Homestyles" />
    <meta property="og:description" content="A one‑stop shop for solar, backup power, lighting and installation services in Kenya. Nationwide delivery from Ruiru, Kiambu." />
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
                <h1 class="mb-2">About MK Homestyles</h1>
                <p class="lead mb-0">Who We Are — A One‑Stop Shop for Solar & Power Backup Solutions in Kenya</p>
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
    <p>MK Homestyles is one of Kenya's biggest names in premium electrical, lighting, and solar supplies. We aim to enhance modern living and empower businesses by easing access to premium quality electrical, lighting, and solar supplies.</p>
    <p>But we don't just offer products; we also provide professional installation services in Nairobi and its environs. This means you will have a fully functional, ready‑to‑use setup by the time we're done.</p>

    <h2>Where We Are</h2>
    <p>We serve homes and businesses across Kenya and throughout East Africa from our base in Ruiru, Kiambu County.</p>
    <ul>
        <li><strong>Headquarters:</strong> Ruiru (with nationwide delivery)</li>
        <li><strong>Coverage:</strong> From Kisumu to Mombasa, Eldoret to Sirare, and across East Africa — distance is never an issue. We deliver wherever you are.</li>
    </ul>

    <h2>What We Offer</h2>
    <h3>Solar Energy Systems</h3>
    <p>MK Homestyles is the ultimate destination for solar power systems: solar panels, solar floodlights, solar streetlights, solar cameras, and complete solar power backup solutions. Simply put, if it’s a solar product, we have it.</p>

    <h3>Portable Power Stations</h3>
    <p>We stock high‑capacity portable power backup systems from Hithium, Bluetti, and EcoFlow in 1000Wh to 2000Wh. Need more output capacity? We can arrange that — request a quotation today.</p>

    <h3>Surveillance Solutions</h3>
    <p>Enhance peace of mind with our diverse security offerings. From nanny cams to discreet bulb‑shaped cameras and robust HIKVision CCTV systems for reliable night performance — we have you covered.</p>

    <h3>Lighting</h3>
    <p>Discover energy‑efficient LEDs, security floodlights, and designer indoor lighting to brighten every space.</p>

    <h3>Home & Lifestyle Supplies</h3>
    <ul>
        <li><strong>Shower Solutions:</strong> Lorenzetti/ENER heads & heating elements</li>
        <li><strong>Power Tools:</strong> INGCO drills, grinders & 165‑piece kits</li>
        <li><strong>Car Essentials:</strong> Emergency combos, tire inflators & chrome kits</li>
        <li><strong>Smart Gadgets:</strong> Bluetooth speakers, humidifiers, TV mounts & more</li>
        <li><strong>Plus:</strong> Expert TV mounting, solar installation in Nairobi & nationwide support</li>
    </ul>

    <h2>Our Story</h2>
    <p>They say necessity is the mother of invention. One founder needed to equip their rural home with solar — a clean, sustainable solution to avoid erratic grid supply and high electricity bills. Quality solar products were expensive while affordable options were often knockoffs. That frustration sparked MK Homestyles — a solution built to fix three gaps:</p>
    <ul>
        <li><strong>Affordability:</strong> Cutting out middlemen to offer fair prices.</li>
        <li><strong>Authenticity:</strong> Sourcing directly from brands like Bluetti, EcoFlow, and Hikvision.</li>
        <li><strong>Local Support:</strong> Training Kenyan technicians to install and maintain every product.</li>
    </ul>
    <p>Today, we power homes from Nairobi and Kajiado to Kakamega and Sirare — because no Kenyan should choose between quality and price.</p>

    <h2>Meet Our Team</h2>
    <p><strong>The Founders:</strong> Maryann &amp; Dennis — the visionaries behind MK Homestyles — now serve as a Duo‑CEO team whose hands‑on approach guides every aspect of operations.</p>
    <p><strong>The Support Squad:</strong> Digital and shop assistants who ensure seamless online and in‑store experiences.</p>
    <p><strong>The Delivery Heroes:</strong> Riders who tackle Nairobi traffic daily to deliver orders safely and on time.</p>
    <p><strong>The Fundis:</strong> We partner with local expert technicians. By the time you’re done with us, you have a fully functional setup that works from day one.</p>

    <h2>Our Mission</h2>
    <p>To ease access to quality electrical, lighting, and solar supplies across Kenya by offering premium products at fair prices, backed by reliable services and genuine warranties.</p>

    <h2>Contact Us</h2>
    <p><strong>Phone:</strong> 0711853439 or 0712270959</p>
    <p><strong>TikTok:</strong> MK_homestyles</p>
    <p><strong>Facebook:</strong> MK_homestyles</p>
    <p><strong>Instagram:</strong> mk_homestyles</p>
    <p>Join the MK Homestyles family and experience quality, convenience, and exceptional service whenever you shop with us.</p>
  </div>
</section>

@endsection
