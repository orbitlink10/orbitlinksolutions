@extends('theme.orbit.layouts.main')

@section('title', 'Orbitlink Installer Program')
@section('meta_description', 'Join the Orbitlink Installer Program for installer pricing, bulk discounts, project quotations, and technical support for networking and CCTV equipment in Kenya.')

@section('main')
@php
    $waLink = orbit_whatsapp_url('Hello Orbitlink Solutions, I would like to join the Installer Program.');
@endphp

<section class="trade-page-hero">
    <div class="container">
        <div class="trade-hero-grid">
            <div>
                <span class="trade-kicker">Installer Program</span>
                <h1>Orbitlink Installer Program</h1>
                <p>Apply for installer pricing, bulk discounts, project quotations, product recommendations, and technical support for networking, CCTV, fibre, wireless, and PoE jobs in Kenya.</p>
                <div class="trade-actions">
                    <a href="#installer-registration" class="btn btn-accent btn-lg">Apply Now</a>
                    <a href="{{ route('send-boq.show') }}" class="btn btn-outline-secondary btn-lg">Send Your BOQ</a>
                    @if($waLink)
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-whatsapp btn-lg"><i class="fab fa-whatsapp me-2"></i>WhatsApp Sales</a>
                    @endif
                </div>
            </div>
            <div class="trade-benefit-panel">
                <h2>Built for project buyers</h2>
                <ul class="trade-check-list">
                    <li>Installer pricing and selected trade deals</li>
                    <li>Bulk discounts and project pricing</li>
                    <li>Priority quotation assistance</li>
                    <li>Technical product recommendations</li>
                    <li>Early stock notifications</li>
                    <li>Warranty and after-sale support</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="trade-benefits-section">
    <div class="container">
        <div class="trade-section-header">
            <span class="trade-kicker">Benefits</span>
            <h2>Why installers apply</h2>
        </div>
        <div class="trade-benefit-grid">
            @foreach([
                ['icon' => 'fas fa-tags', 'title' => 'Installer Pricing', 'copy' => 'Approved accounts can access protected trade pricing where available.'],
                ['icon' => 'fas fa-layer-group', 'title' => 'Bulk Discounts', 'copy' => 'Request better pricing for repeat purchases and multi-site rollouts.'],
                ['icon' => 'fas fa-file-invoice', 'title' => 'Project Quotes', 'copy' => 'Send project lists and BOQs for stock and compatibility checks.'],
                ['icon' => 'fas fa-headset', 'title' => 'Technical Support', 'copy' => 'Get practical equipment advice before buying for client jobs.'],
                ['icon' => 'fas fa-bell', 'title' => 'Stock Alerts', 'copy' => 'Ask for early notifications on selected fast-moving equipment.'],
                ['icon' => 'fas fa-award', 'title' => 'Trade Deals', 'copy' => 'Access selected installer specials when available.'],
            ] as $benefit)
                <div class="trade-benefit">
                    <span class="trade-benefit-icon"><i class="{{ $benefit['icon'] }}"></i></span>
                    <h3>{{ $benefit['title'] }}</h3>
                    <p>{{ $benefit['copy'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="trade-form-section" id="installer-registration">
    <div class="container">
        <div class="trade-form-shell">
            <div class="trade-form-copy">
                <span class="trade-kicker">Application</span>
                <h2>Installer Registration Form</h2>
                <p>Tell us about your business and buying needs. Orbitlink will review your application before installer pricing is enabled on an account.</p>
            </div>
            <form action="{{ route('installer-program.store') }}" method="POST" enctype="multipart/form-data" class="trade-form">
                @csrf
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="full_name" class="form-label">Full name</label>
                        <input type="text" id="full_name" name="full_name" class="form-control" value="{{ old('full_name', Auth::user()->name ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone number</label>
                        <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="company_name" class="form-label">Company or business name</label>
                        <input type="text" id="company_name" name="company_name" class="form-control" value="{{ old('company_name') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="county" class="form-label">County</label>
                        <input type="text" id="county" name="county" class="form-control" value="{{ old('county') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="town" class="form-label">Town</label>
                        <input type="text" id="town" name="town" class="form-control" value="{{ old('town') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="business_type" class="form-label">Type of business</label>
                        <select id="business_type" name="business_type" class="form-select" required>
                            <option value="">Select business type</option>
                            @foreach($businessTypes as $type)
                                <option value="{{ $type }}" {{ old('business_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="years_in_business" class="form-label">Years in business</label>
                        <input type="text" id="years_in_business" name="years_in_business" class="form-control" value="{{ old('years_in_business') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="monthly_purchases" class="form-label">Approximate monthly purchases</label>
                        <input type="text" id="monthly_purchases" name="monthly_purchases" class="form-control" value="{{ old('monthly_purchases') }}" placeholder="KSh range or units">
                    </div>
                    <div class="col-md-6">
                        <label for="whatsapp_number" class="form-label">WhatsApp number</label>
                        <input type="tel" id="whatsapp_number" name="whatsapp_number" class="form-control" value="{{ old('whatsapp_number') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="main_brands" class="form-label">Main brands purchased</label>
                        <input type="text" id="main_brands" name="main_brands" class="form-control" value="{{ old('main_brands') }}" placeholder="MikroTik, Hikvision, Dahua">
                    </div>
                    <div class="col-md-6">
                        <label for="preferred_categories" class="form-label">Preferred product categories</label>
                        <input type="text" id="preferred_categories" name="preferred_categories" class="form-control" value="{{ old('preferred_categories') }}" placeholder="PoE switches, CCTV, fibre">
                    </div>
                    <div class="col-md-6">
                        <label for="business_registration_number" class="form-label">Business registration number</label>
                        <input type="text" id="business_registration_number" name="business_registration_number" class="form-control" value="{{ old('business_registration_number') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="kra_pin" class="form-label">KRA PIN</label>
                        <input type="text" id="kra_pin" name="kra_pin" class="form-control" value="{{ old('kra_pin') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="supporting_document" class="form-label">Supporting document</label>
                        <input type="file" id="supporting_document" name="supporting_document" class="form-control" accept="application/pdf,image/jpeg,image/png,image/webp">
                    </div>
                    <div class="col-12">
                        <span class="form-label d-block">Do you currently buy for client projects?</span>
                        <div class="d-flex gap-3 flex-wrap">
                            <label class="form-check-label"><input type="radio" name="buys_for_projects" value="1" class="form-check-input me-1" {{ old('buys_for_projects', '1') == '1' ? 'checked' : '' }}> Yes</label>
                            <label class="form-check-label"><input type="radio" name="buys_for_projects" value="0" class="form-check-input me-1" {{ old('buys_for_projects') == '0' ? 'checked' : '' }}> No</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-check">
                            <input type="checkbox" name="marketing_consent" value="1" class="form-check-input" {{ old('marketing_consent') ? 'checked' : '' }}>
                            <span class="form-check-label">I agree to receive stock notifications, trade deals, and project pricing updates from Orbitlink.</span>
                        </label>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-accent btn-lg">Submit Application</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
