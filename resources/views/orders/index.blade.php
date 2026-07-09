@extends('layouts.appbar')

@section('content')
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                    <div>
                        <h1 class="page-title mb-1">Orders</h1>
                        <p class="text-muted mb-0">View and manage all customer orders.</p>
                    </div>
                    <ol class="breadcrumb float-sm-right mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Filter Section -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title font-weight-bold">Order List</h3>
                        <form method="GET" action="{{ route('orders.index') }}" class="form-inline">
                            <div class="input-group mr-3">
                                <input
                                    type="search"
                                    name="search"
                                    class="form-control"
                                    placeholder="Search order, customer, email"
                                    value="{{ request('search') }}"
                                    aria-label="Search orders"
                                >
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-secondary" aria-label="Submit search">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <label for="status" class="mr-2">Filter by Status:</label>
                            <select name="status" id="status" class="form-control mr-2">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('orders.index') }}" class="btn btn-secondary ml-2">Reset</a>
                        </form>
                    </div>
                </div>

                <!-- Orders List -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        @forelse($orders as $order)
                            <div class="row align-items-center border-bottom p-3">
                                <!-- Order Details -->
                                <div class="col-md-2 col-sm-4">
                                    <strong>Order ID:</strong> #{{ $order->id }}
                                </div>
                                <div class="col-md-2 col-sm-4">
                                    <strong>Customer:</strong> {{ $order->user->name ?? 'N/A' }}
                                </div>
                                <div class="col-md-2 col-sm-4">
                                    <strong>Status:</strong> 
                                    <span class="badge badge-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="col-md-2 col-sm-4">
                                    <strong>Placed At:</strong> 
                                    @if($order->created_at)
                                        {{ $order->created_at->format('d/m/Y H:i:s') }}
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div class="col-md-2 col-sm-4">
                                    <strong>Total:</strong> {{ number_format($order->total_amount, 2) }} KES
                                </div>
                                <div class="col-md-2 col-sm-4 text-md-right text-sm-left mt-sm-2 mt-md-0">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-muted">
                                No orders found.
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer bg-white d-flex justify-content-center">
                        {{ $orders->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
