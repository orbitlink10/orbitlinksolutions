@extends('layouts.appbar')

@section('content')
@php
    $currency = get_option('currency_symbol', 'KSh');
    $subtotal = $order->subtotal ?? $order->orderItems->sum(function ($item) {
        return $item->price * $item->quantity;
    });
    $subtotal = (float) $subtotal;
    $shipping = (float) ($order->shipping_cost ?? 0);
    $total = (float) ($order->total_amount ?? ($subtotal + $shipping));
    $statusRaw = $order->status ?? 'pending';
    $statusLabel = ucwords(str_replace(['_', '-'], ' ', $statusRaw));
    $statusKey = strtolower(str_replace(['_', ' '], '-', $statusRaw));
    $createdDate = $order->created_at ? $order->created_at->format('d M Y') : 'N/A';
    $backUrl = (Auth::check() && Auth::user()->is_admin()) ? url('orders') : route('account.orders');
    $paymentLabel = 'Processing';
    if ($statusKey === 'pending') {
        $paymentLabel = 'Awaiting payment';
    } elseif (in_array($statusKey, ['processing', 'paid'])) {
        $paymentLabel = 'Payment received';
    } elseif (in_array($statusKey, ['completed', 'delivered'])) {
        $paymentLabel = 'Paid';
    } elseif (in_array($statusKey, ['cancelled', 'canceled', 'failed'])) {
        $paymentLabel = 'Payment issue';
    }
@endphp

<div class="content-wrapper orders-show-page p-4">
    <div class="container-fluid">
        <div class="orders-show-shell">
            <div class="orders-show-hero">
                <div class="orders-show-hero-main">
                    <span class="orders-show-kicker">Order Details</span>
                    <h1>Order #{{ $order->id }}</h1>
                    <p class="orders-show-subtitle">Placed {{ $createdDate }}</p>
                    <div class="orders-show-hero-meta">
                        <div class="orders-meta-item">
                            <span class="orders-meta-label">Customer</span>
                            <span class="orders-meta-value">{{ $order->user->name ?? 'N/A' }}</span>
                        </div>
                        <div class="orders-meta-item">
                            <span class="orders-meta-label">Payment</span>
                            <span class="orders-meta-value">{{ $paymentLabel }}</span>
                        </div>
                        <div class="orders-meta-item">
                            <span class="orders-meta-label">Contact</span>
                            <span class="orders-meta-value">{{ $order->user->phone ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
                <div class="orders-show-actions">
                    <span class="status-pill status-{{ $statusKey }}">{{ $statusLabel }}</span>
                    <a href="{{ $backUrl }}" class="btn btn-light btn-sm">Back to Orders</a>
                </div>
            </div>

            <div class="orders-show-summary">
                <div class="summary-card">
                    <span class="summary-label">Subtotal</span>
                    <span class="summary-value">{{ $currency }} {{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="summary-card">
                    <span class="summary-label">Shipping</span>
                    <span class="summary-value">{{ $currency }} {{ number_format($shipping, 2) }}</span>
                </div>
                <div class="summary-card">
                    <span class="summary-label">Total</span>
                    <span class="summary-value">{{ $currency }} {{ number_format($total, 2) }}</span>
                </div>
            </div>

            <div class="orders-show-grid">
                <div class="info-card">
                    <h3>Customer</h3>
                    <div class="info-row">
                        <span class="info-label">Name</span>
                        <span class="info-value">{{ $order->user->name ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $order->user->email ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Phone</span>
                        <span class="info-value">{{ $order->user->phone ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="info-card">
                    <h3>Shipping</h3>
                    <div class="info-row">
                        <span class="info-label">Address</span>
                        <span class="info-value">{{ $order->shipping_address ?: 'Not provided' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Payment</span>
                        <span class="info-value">{{ $paymentLabel }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Order date</span>
                        <span class="info-value">{{ $createdDate }}</span>
                    </div>
                </div>
            </div>

            <div class="orders-items">
                <div class="orders-items-header">
                    <h3>Order Items</h3>
                    <span class="orders-items-count">{{ $order->orderItems->count() }} items</span>
                </div>
                <div class="table-responsive">
                    @if($order->orderItems->count())
                        <table class="table orders-items-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th class="text-center">Size</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="order-item">
                                                <div class="order-item-thumb">
                                                    @if($item->product && $item->product->photo)
                                                        <img src="{{ url('/storage/' . $item->product->photo) }}" alt="{{ $item->product->name ?? 'Product' }}">
                                                    @else
                                                        <span class="order-item-thumb-fallback">
                                                            <i class="fas fa-box-open"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="order-item-name">{{ $item->product->name ?? 'N/A' }}</div>
                                                    <div class="order-item-meta">SKU: {{ $item->product->id ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->size->name ?? '-' }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">{{ $currency }} {{ number_format($item->price, 2) }}</td>
                                        <td class="text-end">{{ $currency }} {{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="orders-items-empty">
                            <p>No order items found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.orders-show-page {
    background: #f4f7fb;
    min-height: 100vh;
}

.orders-show-shell {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.orders-show-hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    background: linear-gradient(120deg, #1e3a8a 0%, #0f172a 55%, #0b2b3a 100%);
    border-radius: 20px;
    padding: 26px 28px;
    color: #f8fafc;
    position: relative;
    overflow: hidden;
    box-shadow: 0 24px 40px rgba(15, 23, 42, 0.2);
}

.orders-show-hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background: radial-gradient(420px circle at 20% 20%, rgba(59, 130, 246, 0.4), transparent 60%);
    opacity: 0.8;
}

.orders-show-hero-main {
    position: relative;
    z-index: 1;
}

.orders-show-hero h1 {
    margin: 0 0 6px;
    font-size: 1.8rem;
    font-weight: 600;
}

.orders-show-kicker {
    display: inline-block;
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 0.2em;
    color: rgba(248, 250, 252, 0.75);
    background: rgba(248, 250, 252, 0.15);
    padding: 6px 14px;
    border-radius: 999px;
}

.orders-show-subtitle {
    margin: 8px 0 0;
    color: rgba(248, 250, 252, 0.78);
}

.orders-show-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    position: relative;
    z-index: 1;
}

.orders-show-hero-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 18px;
}

.orders-meta-item {
    background: rgba(15, 23, 42, 0.45);
    border: 1px solid rgba(148, 163, 184, 0.35);
    border-radius: 12px;
    padding: 10px 12px;
    min-width: 160px;
}

.orders-meta-label {
    display: block;
    font-size: 0.68rem;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: rgba(226, 232, 240, 0.7);
}

.orders-meta-value {
    display: block;
    font-weight: 600;
    color: #f8fafc;
}

.status-pill {
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    border: 1px solid transparent;
}

.status-pill.status-pending {
    background: rgba(245, 158, 11, 0.22);
    color: #fcd34d;
    border-color: rgba(245, 158, 11, 0.5);
}

.status-pill.status-processing {
    background: rgba(59, 130, 246, 0.2);
    color: #bfdbfe;
    border-color: rgba(59, 130, 246, 0.45);
}

.status-pill.status-completed {
    background: rgba(16, 185, 129, 0.2);
    color: #a7f3d0;
    border-color: rgba(16, 185, 129, 0.45);
}

.status-pill.status-cancelled {
    background: rgba(239, 68, 68, 0.2);
    color: #fecaca;
    border-color: rgba(239, 68, 68, 0.45);
}

.status-pill.status-paid,
.status-pill.status-delivered {
    background: rgba(16, 185, 129, 0.2);
    color: #bbf7d0;
    border-color: rgba(16, 185, 129, 0.45);
}

.status-pill.status-failed {
    background: rgba(239, 68, 68, 0.2);
    color: #fecaca;
    border-color: rgba(239, 68, 68, 0.45);
}

.orders-show-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
}

.summary-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 16px 18px;
    box-shadow: 0 14px 22px rgba(15, 23, 42, 0.06);
}

.summary-label {
    display: block;
    color: #64748b;
    font-size: 0.85rem;
}

.summary-value {
    font-weight: 700;
    color: #0f172a;
    font-size: 1.2rem;
}

.orders-show-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 16px;
}

.info-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 18px;
    box-shadow: 0 14px 24px rgba(15, 23, 42, 0.05);
}

.info-card h3 {
    font-size: 1.05rem;
    margin-bottom: 12px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 10px;
}

.info-label {
    color: #64748b;
    font-size: 0.85rem;
}

.info-value {
    font-weight: 600;
    color: #0f172a;
    text-align: right;
}

.orders-items {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 18px 30px rgba(15, 23, 42, 0.06);
}

.orders-items-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px;
    border-bottom: 1px solid #e2e8f0;
}

.orders-items-count {
    font-size: 0.8rem;
    color: #475569;
    background: #f1f5f9;
    padding: 4px 10px;
    border-radius: 999px;
}

.orders-items-table {
    margin: 0;
}

.orders-items-table thead th {
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.08em;
    background: #f8fafc;
    color: #475569;
    border-bottom: 1px solid #e2e8f0;
}

.orders-items-table td {
    vertical-align: middle;
    border-top: 1px solid #eef2f7;
}

.orders-items-table tbody tr:hover {
    background: #f8fafc;
}

.order-item {
    display: flex;
    align-items: center;
    gap: 12px;
}

.order-item-thumb {
    width: 54px;
    height: 54px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.order-item-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.order-item-thumb-fallback {
    color: #94a3b8;
    font-size: 1.2rem;
}

.order-item-name {
    font-weight: 600;
    color: #0f172a;
}

.order-item-meta {
    color: #64748b;
    font-size: 0.85rem;
}

.orders-items-empty {
    padding: 24px;
    text-align: center;
    color: #64748b;
}

@media (max-width: 768px) {
    .orders-show-hero {
        flex-direction: column;
        align-items: flex-start;
    }

    .orders-show-actions {
        width: 100%;
        justify-content: space-between;
    }

    .orders-show-hero-meta {
        width: 100%;
    }

    .orders-meta-item {
        flex: 1 1 160px;
    }

    .info-row {
        flex-direction: column;
        align-items: flex-start;
    }

    .info-value {
        text-align: left;
    }
}
</style>
@endsection
