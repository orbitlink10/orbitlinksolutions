@extends('layouts.appbar')
@section('content')
<div class="content-wrapper p-4">
    @php
        $totalOrders = $orders->count();
        $pendingOrders = $orders->where('status', 'pending')->count();
        $totalSpend = $orders->sum('total_amount');
    @endphp

    <div class="orders-page">
        <div class="card orders-hero">
            <div class="orders-hero-body">
                <div class="orders-hero-main">
                    <span class="orders-kicker">Account</span>
                    <h1 class="orders-title">My Orders</h1>
                    <p class="orders-subtitle">Track your purchases, payment status, and delivery progress.</p>
                    <div class="orders-hero-actions">
                        <a href="{{ url('shop') }}" class="btn btn-light btn-sm">Continue shopping</a>
                        <a href="{{ route('account.payments') }}" class="btn btn-outline-light btn-sm">Payment history</a>
                    </div>
                </div>
                <div class="orders-hero-stats">
                    <div class="orders-stat">
                        <span class="orders-stat-label">Total orders</span>
                        <span class="orders-stat-value">{{ $totalOrders }}</span>
                    </div>
                    <div class="orders-stat">
                        <span class="orders-stat-label">Pending</span>
                        <span class="orders-stat-value">{{ $pendingOrders }}</span>
                    </div>
                    <div class="orders-stat">
                        <span class="orders-stat-label">Total spend</span>
                        <span class="orders-stat-value">KSh {{ number_format($totalSpend, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($totalOrders > 0)
            <div class="orders-toolbar">
                <div class="orders-search">
                    <i class="fas fa-search"></i>
                    <input
                        type="text"
                        id="ordersSearch"
                        class="form-control orders-search-input"
                        placeholder="Search by order ID, status, or date"
                        aria-label="Search orders"
                        autocomplete="off"
                    >
                </div>
                <div class="orders-count" id="ordersSearchCount"></div>
            </div>
            <div class="orders-list">
                @foreach($orders as $order)
                    <div
                        class="order-card"
                        data-order-id="{{ $order->id }}"
                        data-order-status="{{ strtolower($order->status) }}"
                        data-order-date="{{ $order->created_at->format('d M Y') }}"
                    >
                        <div class="order-card-header">
                            <div>
                                <div class="order-id">Order #{{ $order->id }}</div>
                                <div class="order-date">Placed {{ $order->created_at->format('d M Y') }}</div>
                            </div>
                            <span class="order-status status-{{ str_replace(' ', '-', strtolower($order->status)) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="order-meta">
                            <div class="order-meta-item">
                                <span class="order-meta-label">Total</span>
                                <span class="order-meta-value">KSh {{ number_format($order->total_amount, 2) }}</span>
                            </div>
                            <div class="order-meta-item">
                                <span class="order-meta-label">Payment</span>
                                <span class="order-meta-value">
                                    {{ $order->status == 'pending' ? 'Awaiting payment' : 'Processing' }}
                                </span>
                            </div>
                        </div>
                        <div class="order-actions">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-secondary btn-sm">
                                View Details
                            </a>
                            @if($order->status == 'pending')
                                <span class="order-hint">Complete payment to start processing.</span>
                            @else
                                <span class="order-hint">Your order is being prepared.</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card orders-empty orders-search-empty" id="ordersSearchEmpty" style="display: none;">
                <div class="orders-empty-body">
                    <div class="orders-empty-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4>No matching orders</h4>
                    <p>Try a different order ID, status, or date.</p>
                </div>
            </div>
        @else
            <div class="card orders-empty">
                <div class="orders-empty-body">
                    <div class="orders-empty-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h4>No orders yet</h4>
                    <p>Browse the shop and place your first order today.</p>
                    <a href="{{ url('shop') }}" class="btn btn-primary">Start shopping</a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .orders-page {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .orders-hero {
        border: 0;
        color: #f8fafc;
        background: linear-gradient(120deg, #1e3a8a 0%, #0f172a 55%, #0b2b3a 100%);
        border-radius: 18px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 24px 40px rgba(15, 23, 42, 0.2);
    }

    .orders-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(420px circle at 20% 20%, rgba(59, 130, 246, 0.4), transparent 60%);
        opacity: 0.8;
    }

    .orders-hero-body {
        position: relative;
        z-index: 1;
        padding: 28px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 24px;
        justify-content: space-between;
    }

    .orders-kicker {
        display: inline-flex;
        padding: 6px 14px;
        background: rgba(248, 250, 252, 0.18);
        border-radius: 999px;
        font-size: 0.72rem;
        letter-spacing: 0.2em;
        text-transform: uppercase;
    }

    .orders-title {
        margin: 12px 0 6px;
        font-size: 2rem;
        font-weight: 600;
    }

    .orders-subtitle {
        margin: 0 0 16px;
        color: rgba(248, 250, 252, 0.78);
        max-width: 420px;
    }

    .orders-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .orders-hero-actions .btn-outline-light {
        border-color: rgba(248, 250, 252, 0.6);
        color: #f8fafc;
    }

    .orders-hero-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 12px;
        min-width: 280px;
    }

    .orders-stat {
        background: rgba(15, 23, 42, 0.45);
        border: 1px solid rgba(148, 163, 184, 0.35);
        border-radius: 14px;
        padding: 12px 14px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .orders-stat-label {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: rgba(226, 232, 240, 0.8);
    }

    .orders-stat-value {
        font-size: 1.2rem;
        font-weight: 600;
    }

    .orders-list {
        display: grid;
        gap: 16px;
    }

    .orders-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 14px 16px;
        border-radius: 14px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 12px 22px rgba(15, 23, 42, 0.05);
    }

    .orders-search {
        position: relative;
        flex: 1;
    }

    .orders-search i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .orders-search-input {
        padding-left: 42px;
        border-radius: 12px;
        border-color: #e2e8f0;
    }

    .orders-search-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.15);
    }

    .orders-count {
        font-size: 0.85rem;
        color: #64748b;
        white-space: nowrap;
    }

    .order-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 14px 24px rgba(15, 23, 42, 0.06);
        position: relative;
        overflow: hidden;
    }

    .order-card::before {
        content: "";
        position: absolute;
        inset: 0;
        border-left: 4px solid #2563eb;
        pointer-events: none;
    }

    .order-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
    }

    .order-id {
        font-weight: 600;
        font-size: 1.05rem;
        color: #0f172a;
    }

    .order-date {
        font-size: 0.85rem;
        color: #64748b;
    }

    .order-status {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 999px;
        background: #e2e8f0;
        color: #334155;
        white-space: nowrap;
    }

    .order-status.status-pending {
        background: #fde68a;
        color: #92400e;
    }

    .order-status.status-processing,
    .order-status.status-paid {
        background: #bfdbfe;
        color: #1d4ed8;
    }

    .order-status.status-completed,
    .order-status.status-delivered {
        background: #bbf7d0;
        color: #166534;
    }

    .order-status.status-cancelled,
    .order-status.status-canceled,
    .order-status.status-failed {
        background: #fecdd3;
        color: #9f1239;
    }

    .order-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 12px;
        padding: 12px 0 16px;
        border-top: 1px dashed #e2e8f0;
        border-bottom: 1px dashed #e2e8f0;
    }

    .order-meta-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .order-meta-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #94a3b8;
    }

    .order-meta-value {
        font-weight: 600;
        color: #0f172a;
    }

    .order-actions {
        margin-top: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .order-hint {
        font-size: 0.85rem;
        color: #64748b;
    }

    .orders-empty {
        border-radius: 16px;
        border: 1px dashed #cbd5f5;
        background: #f8fafc;
        text-align: center;
    }

    .orders-search-empty {
        border-style: dashed;
    }

    .orders-empty-body {
        padding: 32px 20px;
    }

    .orders-empty-icon {
        width: 56px;
        height: 56px;
        margin: 0 auto 12px;
        border-radius: 50%;
        background: #e0e7ff;
        color: #4338ca;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    @media (max-width: 768px) {
        .orders-hero-body {
            padding: 22px;
        }

        .orders-title {
            font-size: 1.6rem;
        }

        .orders-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .orders-count {
            text-align: left;
        }
    }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var searchInput = document.getElementById('ordersSearch');
        if (!searchInput) {
            return;
        }

        var cards = Array.prototype.slice.call(document.querySelectorAll('.order-card'));
        var emptyState = document.getElementById('ordersSearchEmpty');
        var countLabel = document.getElementById('ordersSearchCount');
        var total = cards.length;

        var updateResults = function () {
            var query = searchInput.value.trim().toLowerCase();
            var visible = 0;

            cards.forEach(function (card) {
                var haystack = [
                    card.dataset.orderId || '',
                    card.dataset.orderStatus || '',
                    card.dataset.orderDate || ''
                ].join(' ').toLowerCase();

                var match = query === '' || haystack.indexOf(query) !== -1;
                card.style.display = match ? '' : 'none';
                if (match) {
                    visible += 1;
                }
            });

            if (countLabel) {
                countLabel.textContent = visible + ' of ' + total + ' orders';
            }
            if (emptyState) {
                emptyState.style.display = visible === 0 ? 'block' : 'none';
            }
        };

        searchInput.addEventListener('input', updateResults);
        updateResults();
    });
</script>
@endpush
