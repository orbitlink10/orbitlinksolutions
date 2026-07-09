@extends('theme.orbit.layouts.main')
@section('title') Contact Orbitlink Solutions @endsection
@section('main')

<!--Contact Page Start-->
<section class="contact-page bg-light text-dark py-5" style="margin-top: 100px;">
    <div class="container">
        <div class="row">
            <!-- Contact Information Section -->
            <div class="col-lg-6">
                <div class="contact-page__left">
                    <div class="section-title text-left mb-4">
                        <span class="section-title__tagline text-primary">Contact Orbitlink Solutions</span>
                        <h2 class="section-title__title">Ready to get in touch with Orbitlink Solutions</h2>
                    </div>
                    <p class="contact-page__text mb-4">Reach out for product advice, Starlink setup, networking, CCTV, or support. We respond quickly and keep you informed.</p>
                    @php
                        $phone = trim((string) get_option('contact_phone'));
                        $whatsapp = trim((string) get_option('whatsapp_phone'));
                        $phoneDigits = preg_replace('/\D+/', '', $phone);
                        $whatsappDigits = preg_replace('/\D+/', '', $whatsapp);
                    @endphp
                    <ul class="list-unstyled contact-page__contact-list">
                        @if($phone)
                            <li class="mb-3">
                                <div class="d-flex align-items-center">
                                    <span class="icon-phone-call mr-3 text-primary" style="font-size: 1.5rem;"></span>
                                    <div>
                                        <p class="mb-1">Call us</p>
                                        <h4 class="fw-bold mb-0">
                                            <a href="tel:+{{ $phoneDigits }}" class="text-dark">{{ $phone }}</a>
                                        </h4>
                                    </div>
                                </div>
                            </li>
                        @endif
                        @if($whatsapp)
                            <li class="mb-3">
                                <div class="d-flex align-items-center">
                                    <span class="icon-message mr-3 text-primary" style="font-size: 1.5rem;"></span>
                                    <div>
                                        <p class="mb-1">WhatsApp</p>
                                        <h4 class="fw-bold mb-0">
                                            <a href="https://wa.me/{{ $whatsappDigits }}" class="text-dark">{{ $whatsapp }}</a>
                                        </h4>
                                    </div>
                                </div>
                            </li>
                        @endif
                        @if(get_option('contact_email'))
                            <li class="mb-3">
                                <div class="d-flex align-items-center">
                                    <span class="icon-message mr-3 text-primary" style="font-size: 1.5rem;"></span>
                                    <div>
                                        <p class="mb-1">Email</p>
                                        <h4><a href="mailto:{{ get_option('contact_email') }}" class="text-dark fw-bold">{{ get_option('contact_email') }}</a></h4>
                                    </div>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Map or Location Details -->
            <div class="col-lg-6">
                <div class="h-100 bg-white p-4 shadow rounded">
                    <h4 class="text-primary mb-3">Our Location</h4>
                    @php
                        $mapEmbed = trim((string) get_option('map'));
                    @endphp
                    @if($mapEmbed)
                        {!! $mapEmbed !!}
                    @else
                        <p class="text-muted mb-0">Our location map will be added soon. Contact us for directions.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!--Contact Page End-->

@endsection
