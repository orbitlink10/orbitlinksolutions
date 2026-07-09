@extends('theme.lopezspace.layouts.main')
@section('title') FAQs for {{ get_option('site_name') }} @endsection
@section('meta_description', Str::limit(strip_tags(get_option('faq')), 160))
@section('main')



<section class="py-5" id="homepage-description">
    <div class="container">
          {!! get_option('faq') !!}
    </div>
</section>
 @endsection