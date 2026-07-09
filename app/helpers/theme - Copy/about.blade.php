
@extends('theme.layouts.main')
@section('title') About Starlink Kenya @endsection
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
                        <li>About</li>
                    </ul>
                    <h2>About us</h2>
                </div>
            </div>
        </section>
        <!--Page Header End-->

        <!--About Four Start-->
        <section class="about-four">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="about-four__left">
                            <div class="about-four__img-box">
                                <div class="about-four__img-one">
                                    <img src="{{asset ('assets/images/resources/about-four-img-1.jpg')}}" alt="">
                                </div>
                                <div class="about-four__img-two">
                                    <img src="{{asset ('assets/images/resources/about-four-img-2.jpg')}}" alt="">
                                </div>
                                <div class="about-four__border"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="about-four__right">
                            <div class="section-title text-left">
                                <span class="section-title__tagline">About Starlink Kenya</span>
                                <h2 class="section-title__title">Connect with Starlink in Kenya | Fast Satellite Internet Across Kenya</h2>
                            </div>
                            <p class="about-four__text-1">There are many variations of passages of lorem ipsum available
                                the majority have suffered alteration in some form by injected humour. Duis aute irure
                                dolor lipsum is simply free text available.</p>
                            <ul class="about-four__points list-unstyled">
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-arrow-right"></i>
                                    </div>
                                    <div class="text">
                                        <p>Starlink equipment sales</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-arrow-right"></i>
                                    </div>
                                    <div class="text">
                                        <p>professional installation services</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-arrow-right"></i>
                                    </div>
                                    <div class="text">
                                        <p>Technical support and maintenance</p>
                                    </div>
                                </li>
                            </ul>
                            <div class="about-four__btn-box">
                                <a href="{{route ('about-us')}}" class="thm-btn about-four__btn">Discover more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--About Four End-->

        <!--Free Access Start-->
        <section class="free-access">
            <div class="free-access-bg jarallax" data-jarallax data-speed="0.2" data-imgPosition="50% 0%"
                style="background-image: url({{asset ('assets/images/backgrounds/free-access-bg.jpg')}});">
            </div>
            <div class="free-access-shape-1 float-bob-x">
                <img src="{{asset ('assets/images/shapes/free-access-shape-1.png')}}" alt="">
            </div>
            <div class="free-access-shape-2">
                <img src="{{asset ('assets/images/shapes/free-access-shape-2.png')}}" alt="">
            </div>
            <div class="free-access-shape-3">
                <img src="{{asset ('assets/images/shapes/free-access-shape-3.png')}}" alt="">
            </div>
            <div class="container">
                <div class="free-access__inner">
                    <h2 class="free-access__title">Get <span>7 days</span> free access to <br> unlimited movies & TV
                        shows</h2>
                    <div class="free-access__btn-box">
                        <a href="{{route ('product')}}" class="thm-btn free-access__btn">Get started now</a>
                    </div>
                </div>
            </div>
        </section>
        <!--Free Access End-->

        <!--Counter One Start-->
        <section class="counter-one">
            <div class="container">
                <div class="counter-one__inner">
                    <ul class="list-unstyled counter-one__list">
                        <li class="counter-one__single">
                            <div class="counter-one__count-box">
                                <h3 class="odometer" data-count="23">00</h3>
                            </div>
                            <p class="counter-one__text">Years of <br> Experience</p>
                        </li>
                        <li class="counter-one__single">
                            <div class="counter-one__count-box">
                                <h3 class="odometer" data-count="870">00</h3>
                            </div>
                            <p class="counter-one__text">Online <br> Channels</p>
                        </li>
                        <li class="counter-one__single">
                            <div class="counter-one__count-box">
                                <h3 class="odometer" data-count="10000">00</h3>
                            </div>
                            <p class="counter-one__text">Latest <br> Products</p>
                        </li>
                        <li class="counter-one__single">
                            <div class="counter-one__count-box">
                                <h3 class="odometer" data-count="980">00</h3>
                            </div>
                            <p class="counter-one__text">Awesome <br> Movies</p>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <!--Counter One End-->

      

        <!--Brand One Start-->
        <section class="brand-one" style="display: none;">
            <div class="brand-one-shape-1 float-bob-x">
                <img src="{{asset ('assets/images/shapes/brand-one-shape-1.png')}}" alt="">
            </div>
            <div class="brand-one-shape-2 float-bob-y">
                <img src="{{asset ('assets/images/shapes/brand-one-shape-2.png')}}" alt="">
            </div>
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
                                        "spaceBetween": 50,
                                        "slidesPerView": 5
                                    }
                                }}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{asset ('assets/images/brand/brand-1-1.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{asset ('assets/images/brand/brand-1-2.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{asset ('assets/images/brand/brand-1-3.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{asset ('assets/images/brand/brand-1-4.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{asset ('assets/images/brand/brand-1-5.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{asset ('assets/images/brand/brand-1-1.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{asset ('assets/images/brand/brand-1-2.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{asset ('assets/images/brand/brand-1-3.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{asset ('assets/images/brand/brand-1-4.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="{{asset ('assets/images/brand/brand-1-5.png')}}" alt="">
                        </div><!-- /.swiper-slide -->
                    </div>
                </div>
            </div>
        </section>
        <!--Brand One End-->


 @endsection