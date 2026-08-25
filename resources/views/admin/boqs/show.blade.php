@extends('layouts.appbar')

@section('content')
@php
    $fileUrl = $boqSubmission->file_path && uploaded_image_file_path($boqSubmission->file_path)
        ? url('images') . '?path=' . rawurlencode($boqSubmission->file_path)
        : null;
    $quotationUrl = $boqSubmission->quotation_path && uploaded_image_file_path($boqSubmission->quotation_path)
        ? url('images') . '?path=' . rawurlencode($boqSubmission->quotation_path)
        : null;
@endphp
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
        <div>
            <h1 class="h3 mb-1">{{ $boqSubmission->reference }}</h1>
            <p class="text-muted mb-0">{{ $boqSubmission->project_type }} | {{ $boqSubmission->project_location }}</p>
        </div>
        <a href="{{ route('admin.boqs.index') }}" class="btn btn-outline-secondary btn-sm">Back to BOQs</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header"><strong>BOQ details</strong></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Customer</dt><dd class="col-sm-8">{{ $boqSubmission->full_name }}</dd>
                        <dt class="col-sm-4">Company</dt><dd class="col-sm-8">{{ $boqSubmission->company ?: '-' }}</dd>
                        <dt class="col-sm-4">Phone</dt><dd class="col-sm-8">{{ $boqSubmission->phone }}</dd>
                        <dt class="col-sm-4">Email</dt><dd class="col-sm-8">{{ $boqSubmission->email }}</dd>
                        <dt class="col-sm-4">WhatsApp</dt><dd class="col-sm-8">{{ $boqSubmission->whatsapp_number ?: '-' }}</dd>
                        <dt class="col-sm-4">Required date</dt><dd class="col-sm-8">{{ optional($boqSubmission->required_delivery_date)->format('d M Y') ?: '-' }}</dd>
                        <dt class="col-sm-4">Budget</dt><dd class="col-sm-8">{{ $boqSubmission->budget_range ?: '-' }}</dd>
                        <dt class="col-sm-4">Preferred brands</dt><dd class="col-sm-8">{{ $boqSubmission->preferred_brands ?: '-' }}</dd>
                        <dt class="col-sm-4">Uploaded BOQ</dt><dd class="col-sm-8">@if($fileUrl)<a href="{{ $fileUrl }}" target="_blank" rel="noopener">{{ $boqSubmission->file_original_name ?: 'Open BOQ file' }}</a>@else - @endif</dd>
                        <dt class="col-sm-4">Quotation</dt><dd class="col-sm-8">@if($quotationUrl)<a href="{{ $quotationUrl }}" target="_blank" rel="noopener">Open quotation</a>@else - @endif</dd>
                    </dl>
                    <hr>
                    <h5>Requirements</h5>
                    <p class="mb-0">{{ $boqSubmission->requirements ?: 'No written requirements provided.' }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <form action="{{ route('admin.boqs.update', $boqSubmission) }}" method="POST" enctype="multipart/form-data" class="card">
                @csrf
                <div class="card-header"><strong>Update BOQ</strong></div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control" required>
                            @foreach($statuses as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $boqSubmission->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="assigned_to">Assign sales staff</label>
                        <select id="assigned_to" name="assigned_to" class="form-control">
                            <option value="">Unassigned</option>
                            @foreach($salesUsers as $user)
                                <option value="{{ $user->id }}" {{ old('assigned_to', $boqSubmission->assigned_to) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quotation_file">Upload quotation</label>
                        <input type="file" id="quotation_file" name="quotation_file" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx">
                    </div>
                    <div class="form-group">
                        <label for="admin_notes">Admin notes</label>
                        <textarea id="admin_notes" name="admin_notes" class="form-control" rows="6">{{ old('admin_notes', $boqSubmission->admin_notes) }}</textarea>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Save BOQ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
