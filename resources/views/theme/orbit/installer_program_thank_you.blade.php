@extends('theme.orbit.layouts.main')

@section('title', 'Installer Application Received')
@section('meta_description', 'Your Orbitlink Installer Program application has been received.')
@section('robots', 'noindex,nofollow')

@section('main')
<section class="trade-page-hero">
    <div class="container">
        <div class="trade-success">
            <span class="trade-kicker">Application Received</span>
            <h1>Thank you for applying</h1>
            <p>Your installer application has been received. Orbitlink will review the details and contact you through the phone or email submitted.</p>
            @if(session('installer_application_reference'))
                <p class="trade-reference">Application #{{ session('installer_application_reference') }}</p>
            @endif
            <div class="trade-actions">
                <a href="{{ url('shop') }}" class="btn btn-accent btn-lg">Shop Installer Equipment</a>
                <a href="{{ route('send-boq.show') }}" class="btn btn-outline-secondary btn-lg">Send Your BOQ</a>
            </div>
        </div>
    </div>
</section>
@endsection
