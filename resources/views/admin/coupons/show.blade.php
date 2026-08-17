@extends('layouts.appbar')

@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Coupon {{ $coupon->code }}</h1>
            <p class="text-muted mb-0">{{ $coupon->description ?: 'No description' }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary mr-2">Back</a>
            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-primary mr-2">Edit</a>
            <form action="{{ route('admin.coupons.toggle', $coupon) }}" method="POST">
                @csrf
                <button class="btn btn-outline-warning" type="submit">{{ $coupon->is_active ? 'Deactivate' : 'Activate' }}</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <dl class="mb-0">
                        <dt>Discount</dt>
                        <dd>
                            @if($coupon->discount_type === 'percentage')
                                {{ rtrim(rtrim(number_format($coupon->discount_value, 2), '0'), '.') }}%
                            @else
                                KES {{ number_format($coupon->discount_value, 2) }}
                            @endif
                        </dd>
                        <dt>Source</dt>
                        <dd>{{ $coupon->source === 'football_match' ? 'Football match' : 'Manual' }}</dd>
                        <dt>Status</dt>
                        <dd>{{ $coupon->is_active ? 'Active' : 'Inactive' }}</dd>
                        <dt>Used Count</dt>
                        <dd>{{ $coupon->used_count }} / {{ $coupon->usage_limit ?? 'winner-based' }}</dd>
                        <dt>Created By</dt>
                        <dd>{{ $coupon->creator->name ?? '-' }}</dd>
                        <dt>Expiry</dt>
                        <dd>{{ $coupon->expires_at?->format('d M Y H:i') ?? '-' }}</dd>
                        <dt>Redeemed</dt>
                        <dd>{{ $coupon->redeemed_at?->format('d M Y H:i') ?? '-' }}</dd>
                    </dl>
                </div>
                @if(! $coupon->redemptions()->exists())
                    <div class="card-footer bg-white">
                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('Delete this unused coupon?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm" type="submit">Delete Coupon</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h3 class="card-title mb-0">Redemptions</h3>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Order</th>
                                <th>Discount</th>
                                <th>Redeemed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coupon->redemptions as $redemption)
                                <tr>
                                    <td>{{ $redemption->user->name ?? '-' }}</td>
                                    <td><a href="{{ route('orders.show', $redemption->order_id) }}">#{{ $redemption->order_id }}</a></td>
                                    <td>KES {{ number_format($redemption->discount_amount, 2) }}</td>
                                    <td>{{ $redemption->redeemed_at?->format('d M Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">No redemptions yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($coupon->isFootballCoupon())
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h3 class="card-title mb-0">Winner Entitlements</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coupon->entitlements as $entitlement)
                                    <tr>
                                        <td>{{ $entitlement->user->name ?? '-' }}</td>
                                        <td>{{ $entitlement->redeemed_at ? 'Redeemed' : 'Available' }}</td>
                                        <td>{{ $entitlement->order_id ? '#'.$entitlement->order_id : '-' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-4">No winner entitlements.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
