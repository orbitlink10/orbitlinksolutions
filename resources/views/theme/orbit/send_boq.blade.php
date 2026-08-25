@extends('theme.orbit.layouts.main')

@section('title', 'Send Your BOQ - Get Installer Pricing')
@section('meta_description', 'Upload your bill of quantities for CCTV, networking, fibre, Wi-Fi, and access control projects. Orbitlink will prepare a quotation with stock availability and installer pricing.')

@section('main')
@php
    $waLink = orbit_whatsapp_url('Hello Orbitlink Solutions, I would like to send a BOQ for a CCTV/networking project.');
@endphp

<section class="trade-page-hero">
    <div class="container">
        <div class="trade-hero-grid">
            <div>
                <span class="trade-kicker">Project Pricing</span>
                <h1>Send Your BOQ - Get Installer Pricing</h1>
                <p>Upload your bill of quantities or send your equipment requirements. Orbitlink will prepare a quotation with stock availability, compatible alternatives, and installer pricing where applicable.</p>
                <div class="trade-actions">
                    <a href="#boq-form" class="btn btn-accent btn-lg">Upload BOQ</a>
                    @if($waLink)
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-whatsapp btn-lg"><i class="fab fa-whatsapp me-2"></i>Send BOQ on WhatsApp</a>
                    @endif
                </div>
            </div>
            <div class="trade-benefit-panel">
                <h2>Useful for</h2>
                <ul class="trade-check-list">
                    <li>CCTV installations and NVR upgrades</li>
                    <li>Office, hotel, school, and apartment Wi-Fi</li>
                    <li>Point-to-point and ISP deployments</li>
                    <li>Fibre, structured cabling, and racks</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="trade-form-section" id="boq-form">
    <div class="container">
        <div class="trade-form-shell">
            <div class="trade-form-copy">
                <span class="trade-kicker">BOQ Upload</span>
                <h2>Project quotation request</h2>
                <p>Share the file or describe the requirements. A reference number will be generated after submission.</p>
            </div>
            <form action="{{ route('send-boq.store') }}" method="POST" enctype="multipart/form-data" class="trade-form">
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
                        <label for="company" class="form-label">Company</label>
                        <input type="text" id="company" name="company" class="form-control" value="{{ old('company') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="whatsapp_number" class="form-label">WhatsApp number</label>
                        <input type="tel" id="whatsapp_number" name="whatsapp_number" class="form-control" value="{{ old('whatsapp_number') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="project_location" class="form-label">Project location</label>
                        <input type="text" id="project_location" name="project_location" class="form-control" value="{{ old('project_location') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="project_type" class="form-label">Project type</label>
                        <select id="project_type" name="project_type" class="form-select" required>
                            <option value="">Select project type</option>
                            @foreach($projectTypes as $type)
                                <option value="{{ $type }}" {{ old('project_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="boq_file" class="form-label">BOQ file</label>
                        <input type="file" id="boq_file" name="boq_file" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,image/jpeg,image/png,image/webp">
                    </div>
                    <div class="col-md-4">
                        <label for="required_delivery_date" class="form-label">Required delivery date</label>
                        <input type="date" id="required_delivery_date" name="required_delivery_date" class="form-control" value="{{ old('required_delivery_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="budget_range" class="form-label">Budget range</label>
                        <input type="text" id="budget_range" name="budget_range" class="form-control" value="{{ old('budget_range') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="preferred_brands" class="form-label">Preferred brands</label>
                        <input type="text" id="preferred_brands" name="preferred_brands" class="form-control" value="{{ old('preferred_brands') }}">
                    </div>
                    <div class="col-12">
                        <label for="requirements" class="form-label">Describe your project requirements</label>
                        <textarea id="requirements" name="requirements" class="form-control" rows="5" placeholder="Cameras, switches, cable, cabinet, power backup, preferred brands, site notes">{{ old('requirements') }}</textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-accent btn-lg">Submit BOQ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
