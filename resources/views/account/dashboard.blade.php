@extends('layouts.appbar')
@section('content')
<div class="content-wrapper p-4">
    <div class="dashboard-container">
        <!-- Welcome Section -->
        <div class="mb-4">
            <h3 class="text-dark">Dashboard</h3>
            <p class="text-muted">Welcome back, <strong>{{ Auth::user()->name }}</strong>!</p>
        </div>

<!-- Account Overview -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <a href="{{ route('account.orders') }}" class="card shadow-sm border-0 h-100 text-center text-decoration-none link-hover">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                <div class="icon-container mb-3">
                    <i class="fas fa-shopping-cart fa-3x text-primary"></i>
                </div>
                <h5 class="card-title fw-bold text-primary">Orders</h5>
                <p class="fs-5 text-muted mb-0">{{ $ordersCount }} Orders</p>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('wishlist.index') }}" class="card shadow-sm border-0 h-100 text-center text-decoration-none link-hover">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                <div class="icon-container mb-3">
                    <i class="fas fa-heart fa-3x text-success"></i>
                </div>
                <h5 class="card-title fw-bold text-success">Wishlist</h5>
                <p class="fs-5 text-muted mb-0">{{ $wishlistCount }} Items</p>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ url('client.wallet') }}" class="card shadow-sm border-0 h-100 text-center text-decoration-none link-hover">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                <div class="icon-container mb-3">
                    <i class="fas fa-wallet fa-3x text-warning"></i>
                </div>
                <h5 class="card-title fw-bold text-warning">Account Balance</h5>
                <p class="fs-5 text-muted mb-0">{{ number_format($accountBalance, 2) }} KES</p>
            </div>
        </a>
    </div>
</div>




        <!-- Recent Orders -->
        <div class="recent-orders-section">
            <h4 class="text-dark mb-3">Recent Orders</h4>
            @if($recentOrders->isEmpty())
                <div class="alert alert-warning" role="alert">
                    You have no recent orders.
                </div>
            @else
                <div class="list-group">
                    @foreach($recentOrders as $order)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Order ID: #{{ $order->id }}</h6>
                                <p class="mb-1 text-muted">
                                    <strong>Date:</strong> {{ $order->created_at->format('d M, Y') }}
                                </p>
                                <p class="mb-0">
                                    <strong>Status:</strong> {{ ucfirst($order->status) }} |
                                    <strong>Total:</strong> {{ number_format($order->total, 2) }} KES
                                </p>
                            </div>
                            @if($order->status == 'pending')

                         <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary btn-sm">View Details</a>
                         
                            <a href="{{ route('pay_now', $order->id) }}" class="btn btn-primary btn-sm">Pay Now</a>
                        @else
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-secondary btn-sm">View Details</a>
                        @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Recommended Products -->
        <div class="recommended-products mt-5">
            <h4 class="text-dark mb-3">Recommended for You</h4>
            @if($recommendedProducts->isEmpty())
                <div class="alert alert-info" role="alert">
                    No recommended products at the moment.
                </div>
            @else
                <div class="row g-3">
                    @foreach($recommendedProducts as $product)
                        <div class="col-md-3">
                            <div class="card shadow-sm border-0">
                                <img src="{{ url('/') }}/storage/{{ $product->photo }}" alt="{{ $product->name }}" class="card-img-top" alt="{{ $product->name }}">
                                <div class="card-body text-center">
                                    <h6 class="card-title">{{ $product->name }}</h6>
                                    <p class="text-muted">{{ number_format($product->price, 2) }} KES</p>
                                    <a href="{{ route('product_details', $product->slug) }}" class="btn btn-sm btn-primary">View Product</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
