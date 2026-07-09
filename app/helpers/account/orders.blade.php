@extends('theme.my_account')

@section('account-content')
    <h3 class="mb-4">My Orders</h3>
    @if(count($orders) > 0)
        <table class="table table-bordered table-dark">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>{{ $order->status }}</td>
                        <td>KSh {{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            @if($order->status == 'pending')
                            <a href="{{ route('pay_now', $order->id) }}" class="btn btn-info btn-sm">Pay now</a>
                            @else
                            <a href="#" class="btn btn-info btn-sm">View</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>You have no orders.</p>
    @endif
@endsection
