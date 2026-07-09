@extends('theme.layouts.main')
@section('title') Contact with us @endsection
@section('main')



        <!--Contact Page Start-->
        <section class="contact-page bg-dark text-light py-5" style="margin-top: 100px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-page__left">
                            <div class="section-title text-left mb-4">
                                <span class="section-title__tagline text-primary">Contact with us</span>
                                <h2 class="section-title__title">Ready to get in touch with Starlink Kenya</h2>
                            </div>
                            <p class="contact-page__text mb-4">Starlink Kenya offers high-speed satellite internet service by SpaceX, providing reliable connectivity across remote and urban areas, enhancing access to digital services and global opportunities.</p>
                            <ul class="list-unstyled contact-page__contact-list">
                                <li class="mb-3">
                                    <div class="d-flex align-items-center">
                                        <span class="icon-phone-call mr-3 text-primary"></span>
                                        <div>
                                            <p class="mb-1">Have any questions?</p>
                                            <h4><a href="tel:+254729299439" class="text-light">Free +254 729 299 439</a></h4>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-3">
                                    <div class="d-flex align-items-center">
                                        <span class="icon-message mr-3 text-primary"></span>
                                        <div>
                                            <p class="mb-1">Write email</p>
                                            <h4><a href="mailto:info@starlinkkenya.co.ke" class="text-light">info@starlinkkenya.co.ke</a></h4>
                                        </div>
                                    </div>
                                </li>
               
                            </ul>
                        </div>
                    </div>
            
                </div>
            </div>
        </section>
        <!--Contact Page End-->

        <!--Google Map Start-->
        {{-- <section class="google-map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4562.753041141002!2d-118.80123790098536!3d34.152323469614075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80e82469c2162619%3A0xba03efb7998eef6d!2sCostco+Wholesale!5e0!3m2!1sbn!2sbd!4v1562518641290!5m2!1sbn!2sbd"
                class="google-map__one" allowfullscreen></iframe>
        </section> --}}
        <!--Google Map End-->

@endsection
