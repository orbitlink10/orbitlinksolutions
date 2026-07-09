
@extends('theme.star.layouts.main')
@section('title') About {{ get_option('site_name') }} @endsection
@section('main')

<section class="py-5" id="about">
    <div class="container">
       {!! get_option('about') !!}
    </div>
</section>
 @endsection