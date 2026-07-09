@extends('layouts.appbar')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Order Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
                            <li class="breadcrumb-item active">Order Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Order Details Card -->
                        <div class="card card-primary">
                            
                            <div class="card-header">
                                <h3 class="card-title">Order #{{ $order->id ?? ""  }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Customer Name:</label>
                                    <p>{{ $order->user->name }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Customer Email:</label>
                                    <p>{{ $order->user->email }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Customer Phone:</label>
                                    <p>{{ $order->user->phone }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Shipping Address:</label>
                                    <p>{{ $order->shipping_address }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Subtotal:</label>
                                    <p>{{ $order->subtotal }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Shipping Cost:</label>
                                    <p>{{ $order->shipping_cost }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Total Amount:</label>
                                    <p>{{ $order->total_amount }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Status:</label>
                                    <p>{{ ucfirst($order->status) }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Order Date:</label>
                                    <p>
                                        @if($order->created_at)
                                            {{ $order->created_at->format('d/m/Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
