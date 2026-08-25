@extends('layouts.appbar')

@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
        <div>
            <h1 class="h3 mb-1">Installer Applications</h1>
            <p class="text-muted mb-0">Review trade account requests and manage installer status.</p>
        </div>
        <a href="{{ route('installer-program.show') }}" target="_blank" class="btn btn-outline-secondary btn-sm">View public page</a>
    </div>

    <form method="GET" class="card card-body mb-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="">All statuses</option>
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Applicant</th>
                        <th>Business</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Applied</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $application)
                        <tr>
                            <td>
                                <strong>{{ $application->full_name }}</strong>
                                <div class="small text-muted">{{ $application->email }} | {{ $application->phone }}</div>
                            </td>
                            <td>
                                {{ $application->company_name }}
                                <div class="small text-muted">{{ $application->business_type }}</div>
                            </td>
                            <td>{{ $application->town }}, {{ $application->county }}</td>
                            <td><span class="badge badge-{{ $application->status === 'approved' ? 'success' : ($application->status === 'pending' ? 'warning' : 'secondary') }}">{{ $statuses[$application->status] ?? ucfirst($application->status) }}</span></td>
                            <td>{{ $application->created_at->format('d M Y') }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.installers.show', $application) }}" class="btn btn-sm btn-primary">Review</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No installer applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $applications->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
