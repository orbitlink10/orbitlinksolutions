@extends('layouts.appbar')

@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
        <div>
            <h1 class="h3 mb-1">BOQ Submissions</h1>
            <p class="text-muted mb-0">Review project quote requests and manage quotation status.</p>
        </div>
        <a href="{{ route('send-boq.show') }}" target="_blank" class="btn btn-outline-secondary btn-sm">View public page</a>
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
                        <th>Reference</th>
                        <th>Customer</th>
                        <th>Project</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($boqs as $boq)
                        <tr>
                            <td><strong>{{ $boq->reference }}</strong></td>
                            <td>
                                {{ $boq->full_name }}
                                <div class="small text-muted">{{ $boq->email }} | {{ $boq->phone }}</div>
                            </td>
                            <td>
                                {{ $boq->project_type }}
                                <div class="small text-muted">{{ $boq->project_location }}</div>
                            </td>
                            <td><span class="badge badge-info">{{ $statuses[$boq->status] ?? ucfirst($boq->status) }}</span></td>
                            <td>{{ $boq->created_at->format('d M Y') }}</td>
                            <td class="text-right"><a href="{{ route('admin.boqs.show', $boq) }}" class="btn btn-sm btn-primary">Review</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No BOQ submissions found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $boqs->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
