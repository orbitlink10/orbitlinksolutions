
@extends('theme.electro.layouts.main')
@section('title') FAQs For {{ get_option('site_name') }} @endsection
@section('main')

<section class="py-5" id="terms">
    <div class="container">
       {!! get_option('terms') !!}
    </div>
</section>
 @endsection