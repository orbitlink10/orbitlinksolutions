
@extends('theme.star.layouts.main')
@section('title') FAQs For {{ get_option('site_name') }} @endsection
@section('main')

<section class="py-5" id="faq">
    <div class="container">
       {!! get_option('faq') !!}
    </div>
</section>
 @endsection