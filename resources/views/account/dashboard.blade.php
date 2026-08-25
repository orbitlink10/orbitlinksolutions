@extends('layouts.appbar')
@section('content')
<div class="content-wrapper p-4">
    <div class="dashboard-container">
        <!-- Welcome Section -->
        <div class="mb-4">
            <h3 class="text-dark">Dashboard</h3>
            <p class="text-muted">Welcome back, <strong>{{ Auth::user()->name }}</strong>!</p>
        </div>

        @php
            $installerStatus = Auth::user()->installer_status ?: optional($installerApplication)->status;
            $statusLabel = $installerStatus ? ucwords(str_replace('_', ' ', $installerStatus)) : 'Not applied';
            $waLink = orbit_whatsapp_url('Hello Orbitlink Solutions, I need help choosing the right equipment for my project.');
        @endphp
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <span class="badge bg-primary mb-2">Installer Account</span>
                        <h4 class="mb-1">Installer Dashboard</h4>
                        <p class="text-muted mb-0">Status: <strong>{{ $statusLabel }}</strong></p>
                        @if(is_approved_installer(Auth::user()))
                            <p class="text-muted mb-0">Current discount: <strong>{{ Auth::user()->installer_discount_percent ? Auth::user()->installer_discount_percent . '%' : 'Product-specific pricing' }}</strong></p>
                        @endif
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('send-boq.show') }}" class="btn btn-primary btn-sm">Request Project Quote</a>
                        <a href="{{ route('send-boq.show') }}" class="btn btn-outline-secondary btn-sm">Submit BOQ</a>
                        <a href="{{ url('shop') }}" class="btn btn-outline-secondary btn-sm">Shop Installer Products</a>
                        @if($waLink)
                            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-success btn-sm">WhatsApp Sales</a>
                        @endif
                    </div>
                </div>
                <div class="row g-3 mt-3">
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-muted small">Total purchases</div>
                            <strong>KSh {{ number_format($totalPurchases ?? 0, 2) }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-muted small">Open BOQ submissions</div>
                            <strong>{{ $boqSubmissions->whereNotIn('status', ['closed', 'cancelled'])->count() }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-muted small">Trade access</div>
                            <strong>{{ is_approved_installer(Auth::user()) ? 'Enabled' : 'Pending approval' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
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
                                    <strong>Total:</strong> {{ number_format($order->total_amount, 2) }} KES
                                </p>
                            </div>
                            @if($order->status == 'pending')

                         <a href="{{ route('account.orders.show', $order) }}" class="btn btn-secondary btn-sm">View Details</a>
                         
                            <a href="{{ route('pay_now', $order->id) }}" class="btn btn-primary btn-sm">Pay Now</a>
                        @else
                            <a href="{{ route('account.orders.show', $order) }}" class="btn btn-outline-secondary btn-sm">View Details</a>
                        @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="recent-orders-section mt-5">
            <h4 class="text-dark mb-3">Recent BOQ Submissions</h4>
            @if($boqSubmissions->isEmpty())
                <div class="alert alert-info" role="alert">
                    No BOQ submissions yet.
                </div>
            @else
                <div class="list-group">
                    @foreach($boqSubmissions as $boq)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $boq->reference }}</h6>
                                <p class="mb-1 text-muted">{{ $boq->project_type }} | {{ $boq->project_location }}</p>
                                <p class="mb-0"><strong>Status:</strong> {{ \App\Models\BoqSubmission::statuses()[$boq->status] ?? ucfirst($boq->status) }}</p>
                            </div>
                            <span class="badge bg-secondary">{{ $boq->created_at->format('d M Y') }}</span>
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
