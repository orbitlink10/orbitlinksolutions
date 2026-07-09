@extends('theme.starlinknew.layouts.main')

@section('title', 'Application Received')
@section('meta_description', 'Thank you for applying to Spacelink Kenya.')

@section('main')
<section class="section-py bg-light" style="min-height: 60vh;">
  <div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 60vh;">
      <div class="col-md-8 text-center">
        <div class="card border-0 shadow-sm rounded-4 p-5">
          <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
          <h1 class="mt-4 fw-bold">Thank You for Applying!</h1>
          <p class="lead text-muted mb-4">
            We’ve received your application for the <strong>{{ session('applied_position') }}</strong> role.<br>
            Our team will review your resume and be in touch shortly.
          </p>
          <a href="{{ url('/') }}" class="btn btn-primary px-4">Return Home</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
