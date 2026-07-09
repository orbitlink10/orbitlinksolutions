
@extends('theme.layouts.main')
@section('title', $post->meta_title. ' | Starlinkkenya.co.ke')


<link rel="canonical" href="{{ url()->current() }}" />
<meta name="description" content="{{ $post->meta_description }}" />

@section('og_tags')
    <meta property="og:title" content="{{ $post->meta_title }}" />
    <meta property="og:description" content="{{ $post->meta_description }}" />
    <meta property="og:image:width" content="1478" />
    <meta property="og:image:height" content="1108" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="Starlink Kenya" />
    <meta property="og:type" content="website" />
    <meta name="twitter:image" content="/images?path={{ $post->photo }}" />
    <meta name="twitter:site" content="www.starlinkkenya.co.ke" />

    @section('twitter_title', $post->meta_title)
    @section('twitter_description', $post->meta_description)
    @section('twitter_image', url('/images?path=' . $post->photo))
@endsection
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
                        {{-- <li><a href="/">Home</a></li>
                        <li><span>//</span></li> --}}
                        <li>{{$post->meta_title}}</li>
                    </ul>
                    {{-- <h1>{{$post->title}}</h1> --}}
                </div>
            </div>
        </section>
        <!--Page Header End-->

        <!--News Details Start-->
        <section class="news-details">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-7">
                        <div class="news-details__left">
                            <h1 class="news-details__title">{{$post->title}}
                            </h1>
                            <div class="news-details__img">
                                <img src="/images?path={{$post->photo}}" alt="{{$post->alter_text}}">
                                <div class="news-details__date">
                                    <p>18 may</p>
                                </div>
                            </div>
                            <div class="news-details__content">
                                
                                <h2 class="news-details__title">{{$post->head_2}}
                                </h2>

                                <p class="news-details__text-1">{!! $post->meta_description!!}</p>


                                <p class="news-details__text-2">{!! $post->description!!}</p>
                            </div>
                            <div class="news-details__bottom">
                                <p class="news-details__tags">
                                    {{-- <span>Tags</span>
                                    <a href="#">Broadband</a>
                                    <a href="#">Mobility</a> --}}
                                </p>
                                <div class="news-details__social-list">
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-facebook"></i></a>
                                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        <!--News Details End-->

@endsection