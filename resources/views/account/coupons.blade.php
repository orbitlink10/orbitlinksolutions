@extends('layouts.appbar')

@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">My Coupons</h1>
            <p class="text-muted mb-0">Football prediction rewards assigned to your account.</p>
        </div>
        <a href="{{ url('shop') }}" class="btn btn-primary">Shop Now</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Coupon</th>
                        <th>Description</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th>Expiry</th>
                        <th>Order</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entitlements as $entitlement)
                        @php
                            $coupon = $entitlement->coupon;
                        @endphp
                        <tr>
                            <td><strong>{{ $coupon->code }}</strong></td>
                            <td>{{ $coupon->description ?: ($entitlement->footballMatch->home_team . ' vs ' . $entitlement->footballMatch->away_team) }}</td>
                            <td>
                                @if($coupon->discount_type === 'percentage')
                                    {{ rtrim(rtrim(number_format($coupon->discount_value, 2), '0'), '.') }}%
                                @else
                                    KES {{ number_format($coupon->discount_value, 2) }}
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $entitlement->redeemed_at ? 'secondary' : 'success' }}">
                                    {{ $entitlement->redeemed_at ? 'Redeemed' : 'Available' }}
                                </span>
                            </td>
                            <td>{{ $coupon->expires_at?->format('d M Y') ?? '-' }}</td>
                            <td>
                                @if($entitlement->order)
                                    <a href="{{ route('account.orders.show', $entitlement->order) }}">#{{ $entitlement->order_id }}</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-right">
                                @if(! $entitlement->redeemed_at)
                                    <a href="{{ url('shop') }}" class="btn btn-sm btn-outline-primary">Shop Now</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-5">No coupon rewards yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
