@extends('layouts.app')
@section('title', 'Jobs'.' | Ikokazikenya.com')
@section('content')
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs mb-4"> <a href="/">Home</a>
                        <span class="mx-1">/</span> <a href="#!">Jobs</a>
                    </div>
                    <h1 class="mb-4 border-bottom border-primary d-inline-block">{{ $category->name }} Jobs</h1>
                </div>
                
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="widget">
                        <div class="widget-body">
                            @if($categoryPosts->count() >0)
                            @foreach ($categoryPosts as $post)
                            <div class="row mb-4" >
                                <div class="col-12">
                                    <article class="card">
                                        <div class="row">
                                            <div class="col-md-4 col-12" style="display: none;"> <!-- Use the first third for the image -->
                                                <div class="card-image">
                                                    <img loading="lazy" 
                                                    decoding="async" src="/images?path={{ $post['photo'] }}"
                                                    alt="Post Thumbnail" 
                                                    onerror="this.src='{{ asset('assets/images/market5.png') }}'" width="30" height="30">
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-12" style="display: none;"> <!-- Use the remaining two-thirds for content and location -->
                                                <div class="card-body px-0 pb-1">
                                                    <h2 class="post-location"><i class="fas fa-map-marker"></i> {{ $post['location'] }}</h2>
                                                    <h5><a class="post-title post-title-sm" href="{{ route('blog_single', $post->slug) }}">{{ implode(' ', array_slice(str_word_count($post['title'], 1), 0, 4)) }}..</a></h5>
                                                    <p class="card-text">{{ implode(' ', array_slice(str_word_count($post['description'], 1), 0, 5)) }}..</p>
                                                    <div class="content">
                                                        <a class="" href="{{ route('blog_single', $post->slug) }}"><strong>More</strong></a>
                                                    </div>
                                                </div>
                                            </div>

                                            <a class="media align-items-center" href="{{ route('blog_single', $post->slug) }}">
                                                <img loading="lazy" decoding="async"
                                                    src="/images?path={{$post->photo}}"
                                                    alt="Post Thumbnail" 
                                                    onerror="this.src='{{ asset('assets/images/market5.png') }}'"
                                                    width="100" height="100">
                                                    
                                                <div class="media-body ml-3">
                                                <div class="post-info">
                                                    <span class="text-uppercase" >{{$post->company_name}}</span>
                                                   
                                                </div>
                                                    <h5 style="margin-top:-5px">{{$post->title}}</h5>
                                                    <p class="mb-0 small"> Location: {{getCounty($post->location)->name ?? "No County"}}</p>
                                                    <p class="mb-0 small">{{ implode(' ', array_slice(str_word_count(strip_tags($post->description), 1), 0, 10)) }}....
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    </article>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="col-md-6 mb-4">
                                <h1>No Jobs Found for {{ $category->name }}</h1>
                            </div>
                            @endif
                        </div>

                        
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget-blocks">
                        <div class="row">
                            <div class="col-lg-12" style="display: none;">
                                <div class="widget">
                                    <div class="widget-body">
                                        <img loading="lazy" decoding="async" src="{{ asset('assets/images/author.jpg') }}"
                                            alt="About Me" class="w-100 author-thumb-sm d-block">
                                        <h2 class="widget-title my-3">Hootan Safiyari</h2>
                                        <p class="mb-3 pb-2">Hello, I’m Hootan Safiyari. A Content writter, Developer and
                                            Story teller. Working as a Content writter at CoolTech Agency. Quam nihil …</p>
                                        <a href="about.html" class="btn btn-sm btn-outline-primary">Know
                                            More</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="widget">
                                    <h2 class="section-title mb-3">New Jobs</h2>
                                    <div class="widget-body">
                                        <div class="widget-list">
                                            
                                            @foreach ($new as $latest)
                                              
                                            <a class="media align-items-center" href="{{ route('blog_single', $latest->slug) }}">
                                                <img loading="lazy" decoding="async"
                                                    src="/images?path={{$latest->photo}}"
                                                    alt="New Jobs" class="w-100" onerror="this.src='{{ asset('assets/images/market5.png') }}'" width="30" height="30">
                                                    
                                                <div class="media-body ml-3">
                                                  <div class="post-info">
                                                    <span class="text-uppercase" >{{$latest->company_name}}</span>
                                                </div>
                                                    <h5 style="margin-top:-5px">{{$latest->title}}</h5>
                                                    <p class="mb-0 small"> Location: {{getCounty($latest->location)->name ?? "No County"}}</p>
                                                    <p class="mb-0 small">{{ implode(' ', array_slice(str_word_count(strip_tags($latest->description), 1), 0, 10)) }}....
                                                    </p>
                                                </div>
                                            </a>
                                            @endforeach
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="widget">
                                    <h2 class="section-title mb-3">Categories</h2>
                                    <div class="widget-body">
                                        <ul class="widget-list">

                                            @foreach ($tags as $tag)
                                                <li><a href="{{route ('view_category',$tag->slug)}}">{{ $tag->name }}<span
                                                            class="ml-auto">({{ $tag->posts->count() }})</span></a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
