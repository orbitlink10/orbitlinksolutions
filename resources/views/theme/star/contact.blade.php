@extends('theme.star.layouts.main')
@section('title') Contact with us @endsection
@section('main')

<!--Contact Page Start-->
<section class="contact-page bg-light text-dark py-5" style="margin-top: 100px;">
    <div class="container">
        <div class="row">
            <!-- Contact Information Section -->
            <div class="col-lg-6">
                <div class="contact-page__left">
                    <div class="section-title text-left mb-4">
                        <span class="section-title__tagline text-primary">Contact with us</span>
                        <h2 class="section-title__title">Ready to get in touch with Starlink Kenya</h2>
                    </div>
                    <p class="contact-page__text mb-4">Discover Starlink Kenya, your trusted provider of Starlink kits and professional installation services in Kenya. We offer high-quality satellite internet solutions to ensure fast, reliable connectivity across the country. </p>
                    <ul class="list-unstyled contact-page__contact-list">
                        <!-- Phone Contact -->
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <span class="icon-phone-call mr-3 text-primary" style="font-size: 1.5rem;"></span>
                                <div>
                                    <p class="mb-1">Have any questions?</p>
                                    <h4><a href="tel:{{get_option('contact_phone') }}" class="text-dark fw-bold">{{get_option('contact_phone') }}</a></h4>
                                </div>
                            </div>
                        </li>
                        <!-- Email Contact -->
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <span class="icon-message mr-3 text-primary" style="font-size: 1.5rem;"></span>
                                <div>
                                    <p class="mb-1">Write email</p>
                                    <h4><a href="mailto:{{get_option('contact_email')}}" class="text-dark fw-bold">{{get_option('contact_email') }}</a></h4>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Placeholder for Google Maps or Other Content -->
            <div class="col-lg-6">
                <div class="h-100 bg-white p-4 shadow rounded">
                    <h4 class="text-primary mb-3">Our Location</h4>
{!! get_option('map') !!}
                </div>
            </div>
        </div>
    </div>
</section>
<!--Contact Page End-->



@endsection
