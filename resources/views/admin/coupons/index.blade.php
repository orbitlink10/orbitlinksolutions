@extends('layouts.appbar')

@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Coupons</h1>
            <p class="text-muted mb-0">Manual and football-generated checkout rewards.</p>
        </div>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">Create Coupon</a>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.coupons.index') }}" class="row g-2">
                <div class="col-md-5">
                    <input type="search" name="search" class="form-control" placeholder="Search code or description" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="source" class="form-control">
                        <option value="">All sources</option>
                        <option value="manual" {{ request('source') === 'manual' ? 'selected' : '' }}>Manual</option>
                        <option value="football_match" {{ request('source') === 'football_match' ? 'selected' : '' }}>Football</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">All statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" type="submit">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Coupon Code</th>
                        <th>Description</th>
                        <th>Discount</th>
                        <th>Source</th>
                        <th>Status</th>
                        <th>Redemptions</th>
                        <th>Created</th>
                        <th>Expiry</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td><strong>{{ $coupon->code }}</strong></td>
                            <td>{{ $coupon->description ?: '-' }}</td>
                            <td>
                                @if($coupon->discount_type === 'percentage')
                                    {{ rtrim(rtrim(number_format($coupon->discount_value, 2), '0'), '.') }}%
                                @else
                                    KES {{ number_format($coupon->discount_value, 2) }}
                                @endif
                            </td>
                            <td>{{ $coupon->source === 'football_match' ? 'Football' : 'Manual' }}</td>
                            <td>
                                <span class="badge badge-{{ $coupon->is_active ? 'success' : 'secondary' }}">
                                    {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $coupon->redemptions_count }} / {{ $coupon->usage_limit ?? 'winner-based' }}</td>
                            <td>{{ $coupon->created_at?->format('d M Y') }}</td>
                            <td>{{ $coupon->expires_at?->format('d M Y') ?? '-' }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.coupons.show', $coupon) }}" class="btn btn-sm btn-outline-info">View</a>
                                <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">No coupons found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $coupons->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
