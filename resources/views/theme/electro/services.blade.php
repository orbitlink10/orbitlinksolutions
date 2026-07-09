@extends('theme.electro.layouts.main')

@section('main')

        <!--Page Header Start-->
        <section class="page-header">
            <div class="page-header-bg" style="background-image: url({{asset ('assets/images/backgrounds/page-header-bg.jpg')}})">
            </div>
            <div class="main-slider-border"></div>
            <div class="main-slider-border main-slider-border-two"></div>
            <div class="main-slider-border main-slider-border-three"></div>
            <div class="main-slider-border main-slider-border-four"></div>
            <div class="main-slider-border main-slider-border-five"></div>
            <div class="main-slider-border main-slider-border-six"></div>
            <div class="container">
                <div class="page-header__inner">
                    <ul class="thm-breadcrumb list-unstyled">
                        <li><a href="/">Home</a></li>
                        <li><span>//</span></li>
                        <li>Services</li>
                    </ul>
                    <h2>Services</h2>
                </div>
            </div>
        </section>
        <!--Page Header End-->

        <!--Feature One Start-->
        <section class="feature-one feature-three">
            <div class="container">
                <div class="row">
                    <!--Feature One Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInLeft" data-wow-delay="100ms">
                        <div class="feature-one__single">
                            <div class="feature-one__single-content-box">
                                <div class="feature-one-shape">
                                    <img src="{{asset ('assets/images/shapes/feature-one-shape-1.png')}}" alt="">
                                </div>
                                <div class="feature-one__single-inner">
                                    <div class="feature-one__content">
                                        <h3 class="feature-one__title"><a href="broadband.html">Fiber <br> Broadband</a>
                                        </h3>
                                        <p class="feature-one__text">Nam nec est id dui efficitur <br> auctor et sit
                                            amet
                                            nunc.
                                        </p>
                                    </div>
                                    <div class="feature-one__icon">
                                        <span class="icon-wifi-router"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Feature One Single End-->
                    <!--Feature One Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInLeft" data-wow-delay="200ms">
                        <div class="feature-one__single">
                            <div class="feature-one__single-content-box">
                                <div class="feature-one-shape">
                                    <img src="{{asset ('assets/images/shapes/feature-one-shape-1.png')}}" alt="">
                                </div>
                                <div class="feature-one__single-inner">
                                    <div class="feature-one__content">
                                        <h3 class="feature-one__title"><a href="tv-streaming.html">TV & <br>
                                                Streaming</a></h3>
                                        <p class="feature-one__text">Nam nec est id dui efficitur <br> auctor et sit
                                            amet
                                            nunc.
                                        </p>
                                    </div>
                                    <div class="feature-one__icon">
                                        <span class="icon-smart-tv"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Feature One Single End-->
                    <!--Feature One Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInLeft" data-wow-delay="300ms">
                        <div class="feature-one__single">
                            <div class="feature-one__single-content-box">
                                <div class="feature-one-shape">
                                    <img src="{{asset ('assets/images/shapes/feature-one-shape-1.png')}}" alt="">
                                </div>
                                <div class="feature-one__single-inner">
                                    <div class="feature-one__content">
                                        <h3 class="feature-one__title"><a href="all-for-mobile.html">All for <br>
                                                Mobiles</a></h3>
                                        <p class="feature-one__text">Nam nec est id dui efficitur <br> auctor et sit
                                            amet
                                            nunc.
                                        </p>
                                    </div>
                                    <div class="feature-one__icon">
                                        <span class="icon-mobile-app"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Feature One Single End-->
                </div>
            </div>
        </section>
        <!--Feature One End-->

        <!--Brand Two Start-->
        <section class="brand-two">
            <div class="container">
                <div class="thm-swiper__slider swiper-container" data-swiper-options='{"spaceBetween": 100, "slidesPerView": 5, "autoplay": { "delay": 5000 }, "breakpoints": {
                                    "0": {
                                        "spaceBetween": 30,
                                        "slidesPerView": 2
                                    },
                                    "375": {
                                        "spaceBetween": 30,
                                        "slidesPerView": 2
                                    },
                                    "575": {
                                        "spaceBetween": 30,
                                        "slidesPerView": 3
                                    },
                                    "767": {
                                        "spaceBetween": 50,
                                        "slidesPerView": 4
                                    },
                                    "991": {
                                        "spaceBetween": 50,
                                        "slidesPerView": 5
                                    },
                                    "1199": {
                                        "spaceBetween": 100,
                                        "slidesPerView": 5
                                    }
                                }}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{asset('assets/images/brand/brand-2-1.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{asset('assets/images/brand/brand-2-2.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{asset('assets/images/brand/brand-2-3.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{asset('assets/images/brand/brand-2-4.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{asset('assets/images/brand/brand-2-5.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{ asset ('assets/images/brand/brand-2-1.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{asset('assets/images/brand/brand-2-2.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{asset('assets/images/brand/brand-2-3.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{asset('assets/images/brand/brand-2-4.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{asset('assets/images/brand/brand-2-5.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                    </div>
                </div>
            </div>
        </section>
        <!--Brand Two End-->

        <!--Benefits Start-->
        <section class="benefits">
            <div class="benefits__wrapper">
                <div class="benefits__left">
                    <div class="benefits__left-bg"
                        style="background-image: url({{asset ('assets/images/backgrounds/benefits-bg-one.jpg')}});"></div>
                </div>
                <div class="benefits__right">
                    <div class="benefits-shape-one"
                        style="background-image: url({{asset ('assets/images/shapes/benefits-shape-1.png')}});">
                    </div>
                    <div class="benefits__content-box">
                        <div class="section-title text-left">
                            <span class="section-title__tagline">Only Benefits</span>
                            <h2 class="section-title__title">Great reasons make you choose us</h2>
                        </div>
                        <p class="benefits__text">Duis mollis varius quam sed congue. Aliquam porttitor ultricies
                            porttitor elementum. Nullam pretium id massa ut placerat. Class aptent taciti sociosqu ad
                            litora.</p>
                        <div class="benefits__list-box">
                            <ul class="list-unstyled benefits__list">
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-check"></i>
                                    </div>
                                    <div class="content">
                                        <h4>Satellite Chanells</h4>
                                        <p>Strategy experience and expertise to enable.</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-check"></i>
                                    </div>
                                    <div class="content">
                                        <h4>Free Installation</h4>
                                        <p>Strategy experience and expertise to enable.</p>
                                    </div>
                                </li>
                            </ul>
                            <ul class="list-unstyled benefits__list benefits__list-two">
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-check"></i>
                                    </div>
                                    <div class="content">
                                        <h4>24/7 Support</h4>
                                        <p>Strategy experience and expertise to enable.</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-check"></i>
                                    </div>
                                    <div class="content">
                                        <h4>Best Tariff Plans</h4>
                                        <p>Strategy experience and expertise to enable.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Benefits End-->

        <!--Services One Start-->
        <section class="services-one">
            <div class="services-one-shape-1 float-bob-x">
                <img src="{{asset ('assets/images/shapes/services-one-shape-1.png')}}" alt="">
            </div>
            <div class="services-one-shape-2 float-bob-y">
                <img src="{{asset ('assets/images/shapes/services-one-shape-2.png')}}" alt="">
            </div>
            <div class="container">
                <div class="services-one__top">
                    <div class="row">
                        <div class="col-xl-7 col-lg-7">
                            <div class="services-one__top-left">
                                <div class="section-title text-left">
                                    <span class="section-title__tagline">services we’re offering</span>
                                    <h2 class="section-title__title">What we’re providing to <br> our customers</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-5">
                            <div class="services-one__top-right">
                                <p class="services-one__top-tex">Duis mollis varius quam sed congue. Aliquam porttitor
                                    ultricies porttitor elementum. Nullam pretium id massa ut placerat. Class aptent
                                    taciti sociosqu ad litora.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="services-one__bottom">
                    <div class="row">
                        <!--Services One Single Start-->
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <div class="services-one__single">
                                <div class="services-one__single-inner">
                                    <div class="services-one__single-bg"
                                        style="background-image: url({{asset ('assets/images/backgrounds/services-one-single-bg.jpg')}});">
                                    </div>
                                    <div class="services-one__icon">
                                        <span class="icon-tv-box"></span>
                                    </div>
                                    <h3 class="services-one__title"><a href="satelite-tv.html">Smart TV</a></h3>
                                    <p class="services-one__text">Nunc eleifend eget nunc eget consequat. Etiam sed
                                        varius est. Proin et lacus odio.</p>
                                </div>
                                <div class="services-one__arrow">
                                    <a href="satelite-tv.html"><span class="icon-right-arrow1"></span></a>
                                </div>
                            </div>
                        </div>
                        <!--Services One Single End-->
                        <!--Services One Single Start-->
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <div class="services-one__single">
                                <div class="services-one__single-inner">
                                    <div class="services-one__single-bg"
                                        style="background-image: url({{asset ('assets/images/backgrounds/services-one-single-bg.jpg')}});">
                                    </div>
                                    <div class="services-one__icon">
                                        <span class="icon-wifi-router"></span>
                                    </div>
                                    <h3 class="services-one__title"><a href="broadband.html">Broadband</a></h3>
                                    <p class="services-one__text">Nunc eleifend eget nunc eget consequat. Etiam sed
                                        varius est. Proin et lacus odio.</p>
                                </div>
                                <div class="services-one__arrow">
                                    <a href="broadband.html"><span class="icon-right-arrow1"></span></a>
                                </div>
                            </div>
                        </div>
                        <!--Services One Single End-->
                        <!--Services One Single Start-->
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <div class="services-one__single">
                                <div class="services-one__single-inner">
                                    <div class="services-one__single-bg"
                                        style="background-image: url({{asset ('assets/images/backgrounds/services-one-single-bg.jpg')}});">
                                    </div>
                                    <div class="services-one__icon">
                                        <span class="icon-mobile-app"></span>
                                    </div>
                                    <h3 class="services-one__title"><a href="all-for-mobile.html">All for mobile</a>
                                    </h3>
                                    <p class="services-one__text">Nunc eleifend eget nunc eget consequat. Etiam sed
                                        varius est. Proin et lacus odio.</p>
                                </div>
                                <div class="services-one__arrow">
                                    <a href="all-for-mobile.html"><span class="icon-right-arrow1"></span></a>
                                </div>
                            </div>
                        </div>
                        <!--Services One Single End-->
                        <!--Services One Single Start-->
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <div class="services-one__single">
                                <div class="services-one__single-inner">
                                    <div class="services-one__single-bg"
                                        style="background-image: url({{asset ('assets/images/backgrounds/services-one-single-bg.jpg')}});">
                                    </div>
                                    <div class="services-one__icon">
                                        <span class="icon-high-speed"></span>
                                    </div>
                                    <h3 class="services-one__title"><a href="fast-internet.html">Fast internet</a></h3>
                                    <p class="services-one__text">Nunc eleifend eget nunc eget consequat. Etiam sed
                                        varius est. Proin et lacus odio.</p>
                                </div>
                                <div class="services-one__arrow">
                                    <a href="fast-internet.html"><span class="icon-right-arrow1"></span></a>
                                </div>
                            </div>
                        </div>
                        <!--Services One Single End-->
                    </div>
                </div>
            </div>
        </section>
        <!--Services One End-->

        <!--Service Available Start-->
        <section class="service-available service-available-two">
            <div class="container">
                <div class="service-available__inne">
                    <div class="service-available__shape-1 float-bob-y">
                        <img src="{{asset ('assets/images/shapes/service-available-shape-1.png')}}" alt="">
                    </div>
                    <div class="service-available__shape-2 float-bob-x">
                        <img src="{{asset ('assets/images/shapes/service-available-shape-2.png')}}" alt="">
                    </div>
                    <div class="service-available__shape-3 float-bob-y">
                        <img src="{{asset ('assets/images/shapes/service-available-shape-3.png')}}" alt="">
                    </div>
                    <div class="service-available__shape-4 float-bob-x">
                        <img src="{{asset ('assets/images/shapes/service-available-shape-4.png')}}" alt="">
                    </div>
                    <div class="service-available__left">
                        <h3 class="service-available__title">Check ability to connect our <br>
                            services in your area</h3>
                    </div>
                    <div class="service-available__right">
                        <form class="service-available__form">
                            <div class="service-available__input-box">
                                <input type="text" placeholder="Enter address" name="address">
                                <button type="submit" class="service-available__btn thm-btn">Check availability</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!--Service Available End-->

 @endsection