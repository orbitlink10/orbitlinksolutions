@extends('layouts.appbar')

@section('content')
@php
    $documentUrl = $installerApplication->supporting_document_path && uploaded_image_file_path($installerApplication->supporting_document_path)
        ? url('images') . '?path=' . rawurlencode($installerApplication->supporting_document_path)
        : null;
@endphp
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
        <div>
            <h1 class="h3 mb-1">{{ $installerApplication->full_name }}</h1>
            <p class="text-muted mb-0">{{ $installerApplication->company_name }} | {{ $installerApplication->business_type }}</p>
        </div>
        <a href="{{ route('admin.installers.index') }}" class="btn btn-outline-secondary btn-sm">Back to applications</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card mb-3">
                <div class="card-header"><strong>Applicant details</strong></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Name</dt><dd class="col-sm-8">{{ $installerApplication->full_name }}</dd>
                        <dt class="col-sm-4">Phone</dt><dd class="col-sm-8">{{ $installerApplication->phone }}</dd>
                        <dt class="col-sm-4">Email</dt><dd class="col-sm-8">{{ $installerApplication->email }}</dd>
                        <dt class="col-sm-4">Company</dt><dd class="col-sm-8">{{ $installerApplication->company_name }}</dd>
                        <dt class="col-sm-4">Location</dt><dd class="col-sm-8">{{ $installerApplication->town }}, {{ $installerApplication->county }}</dd>
                        <dt class="col-sm-4">Years in business</dt><dd class="col-sm-8">{{ $installerApplication->years_in_business ?: '-' }}</dd>
                        <dt class="col-sm-4">Monthly purchases</dt><dd class="col-sm-8">{{ $installerApplication->monthly_purchases ?: '-' }}</dd>
                        <dt class="col-sm-4">Brands</dt><dd class="col-sm-8">{{ $installerApplication->main_brands ?: '-' }}</dd>
                        <dt class="col-sm-4">Categories</dt><dd class="col-sm-8">{{ $installerApplication->preferred_categories ?: '-' }}</dd>
                        <dt class="col-sm-4">Buys for projects</dt><dd class="col-sm-8">{{ $installerApplication->buys_for_projects ? 'Yes' : 'No' }}</dd>
                        <dt class="col-sm-4">WhatsApp</dt><dd class="col-sm-8">{{ $installerApplication->whatsapp_number ?: '-' }}</dd>
                        <dt class="col-sm-4">Business Reg.</dt><dd class="col-sm-8">{{ $installerApplication->business_registration_number ?: '-' }}</dd>
                        <dt class="col-sm-4">KRA PIN</dt><dd class="col-sm-8">{{ $installerApplication->kra_pin ?: '-' }}</dd>
                        <dt class="col-sm-4">Document</dt><dd class="col-sm-8">@if($documentUrl)<a href="{{ $documentUrl }}" target="_blank" rel="noopener">Open supporting document</a>@else - @endif</dd>
                    </dl>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><strong>Matched customer order history</strong></div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td><a href="{{ route('orders.show', $order->id) }}">#{{ $order->id }}</a></td>
                                    <td>{{ ucfirst($order->status) }}</td>
                                    <td>KSh {{ number_format($order->total_amount, 2) }}</td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-muted text-center py-3">No matched orders found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <form action="{{ route('admin.installers.update', $installerApplication) }}" method="POST" class="card">
                @csrf
                <div class="card-header"><strong>Review application</strong></div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="status">Installer status</label>
                        <select id="status" name="status" class="form-control" required>
                            @foreach($statuses as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $installerApplication->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="approved_discount_percent">Installer discount (%)</label>
                        <input type="number" step="0.01" min="0" max="100" id="approved_discount_percent" name="approved_discount_percent" class="form-control" value="{{ old('approved_discount_percent', $installerApplication->approved_discount_percent) }}">
                    </div>
                    <div class="form-group">
                        <label for="admin_notes">Admin notes</label>
                        <textarea id="admin_notes" name="admin_notes" class="form-control" rows="6">{{ old('admin_notes', $installerApplication->admin_notes) }}</textarea>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Save Review</button>
                </div>
            </form>

            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="mb-2">Account link</h5>
                    @if($matchedUser)
                        <p class="mb-1"><strong>{{ $matchedUser->name }}</strong></p>
                        <p class="text-muted mb-0">{{ $matchedUser->email }} | Status: {{ $matchedUser->installer_status ?: 'none' }}</p>
                    @else
                        <p class="text-muted mb-0">No existing customer account matches this email. Approval will be stored on the application until the customer account exists.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
