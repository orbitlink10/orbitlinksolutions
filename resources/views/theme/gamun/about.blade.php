@extends('theme.gamun.layouts.main')
@section('title') About {{ get_option('site_name') }} @endsection
@section('meta_description', Str::limit(strip_tags(get_option('about')), 160))

@section('main')

<!-- Homepage Description Section -->
<section class="py-5" id="homepage-description">
    <div class="container">
        <h2>About {{ get_option('site_name') }}</h2>
        {!! get_option('about', 'Welcome to our website. Learn more about our services and company.') !!}
    </div>
</section>

@endsection
