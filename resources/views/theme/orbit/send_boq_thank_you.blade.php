@extends('theme.orbit.layouts.main')

@section('title', 'BOQ Received')
@section('meta_description', 'Your BOQ has been received by Orbitlink Solutions.')
@section('robots', 'noindex,nofollow')

@section('main')
<section class="trade-page-hero">
    <div class="container">
        <div class="trade-success">
            <span class="trade-kicker">BOQ Received</span>
            <h1>We received your BOQ</h1>
            <p>Our team will review your requirements and prepare a quotation with stock availability, compatible alternatives, and installer pricing where applicable.</p>
            <p class="trade-reference">{{ $boq->reference }}</p>
            <div class="trade-actions">
                <a href="{{ url('shop') }}" class="btn btn-accent btn-lg">Continue Shopping</a>
                <a href="{{ route('installer-program.show') }}" class="btn btn-outline-secondary btn-lg">Join Installer Program</a>
            </div>
        </div>
    </div>
</section>
@endsection
