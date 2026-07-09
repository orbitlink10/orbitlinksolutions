@extends('theme.electro.layouts.main')
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
                        <h2 class="section-title__title">Ready to get in touch with MK Homestyles</h2>
                    </div>
                    <p class="contact-page__text mb-4">Reach out to MK Homestyles for product inquiries, orders, or installation support. We’re here to help and respond quickly.</p>
                    <ul class="list-unstyled contact-page__contact-list">
                        <!-- Phone Contact -->
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <span class="icon-phone-call mr-3 text-primary" style="font-size: 1.5rem;"></span>
                                <div>
                                    <p class="mb-1">Our phone numbers are</p>
                                    <h4 class="fw-bold mb-0">
                                        <a href="tel:+254711853439" class="text-dark">+254 711 853 439</a>
                                        <span class="text-muted"> or </span>
                                        <a href="tel:+254792506158" class="text-dark">+254 792 506 158</a>
                                        <span class="text-muted"> or </span>
                                        <a href="tel:+254712270959" class="text-dark">+254 712 270 959</a>
                                    </h4>
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
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3796.8402102390287!2d36.96094850000001!3d-1.1465231999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f47005a5fe845%3A0x2630298421b7f479!2sMK_Homestyles!5e1!3m2!1sen!2ske!4v1762323952978!5m2!1sen!2ske" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Contact Page End-->



@endsection
