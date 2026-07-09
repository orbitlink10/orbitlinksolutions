@extends('layouts.app')
@section('title', $page->title.' | Ikokazikenya.com')
@section('content')
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="search-form" style="text-align: right;">
                        <form method="GET" action="{{ route ('blog')}}">
                            @csrf
                            <div class="form-group row">
                                {{-- <label for="job_title" class="col-md-2 col-form-label">Job Title</label> --}}
                                <div class="col-md-3">
                                    <input type="text" id="job_title" name="job_title" class="form-control" placeholder="Enter job title">
                                </div>
                                {{-- <label for="location" class="col-md-2 col-form-label">Location</label> --}}
                                <div class="col-md-3">
                                    <?php $counties=\App\Models\County::all(); ?>
                                    <select id="location" name="location" class="form-control">
                                        <option value="">Select location</option>
                                        @foreach ($counties as $count )
                                            <option value="{{$count->id}}">{{$count->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <?php $categories=\App\Models\Category::all(); ?>
                                    <select id="location" name="category" class="form-control">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $cat )
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <article>
                        <img loading="lazy" decoding="async" src="/images?path={{ $page->photo }}" alt="Post Thumbnail"
                        onerror="this.src='{{ asset('assets/images/home.png') }}'" width="1900" height="250">
                        <ul class="post-meta mb-2 mt-4">
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    style="margin-right:5px;margin-top:-4px" class="text-dark" viewBox="0 0 16 16">
                                    <path d="M5.5 10.5A.5.5 0 0 1 6 10h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z" />
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z" />
                                    <path
                                        d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z" />
                                </svg> 
                            </li>
                        </ul>
                        <h1 class="my-3">{{ $page->title }}</h1>
                        
                        <div class="content text-left">
                            {!! $page->description !!}
                        </div>
                    </article>


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
                                          <article class="card mb-4" style="display: none;">
                                              <div class="card-image">
                                                  <div class="post-info"> <span class="text-uppercase">1 minutes
                                                          read</span>
                                                  </div>
                                                  <img loading="lazy" decoding="async"
                                                      src="{{ asset('assets/images/post/post-9.jpg') }}"
                                                      alt="Post Thumbnail" class="w-100">
                                              </div>
                                              <div class="card-body px-0 pb-1">
                                                  <h3><a class="post-title post-title-sm" href="article.html">Portugal and
                                                          France Now
                                                          Allow Unvaccinated Tourists</a></h3>
                                                  <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing
                                                      elit, sed do eiusmod tempor …</p>
                                                  <div class="content"> <a class="read-more-btn" href="article.html">Read
                                                          Full Article</a>
                                                  </div>
                                              </div>
                                          </article>
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
                                                  <p>{{ implode(' ', array_slice(str_word_count(strip_tags($latest->description), 1), 0, 10)) }}..
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
