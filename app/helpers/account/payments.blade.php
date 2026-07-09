@extends('theme.my_account')

@section('account-content')
    <h3 class="mb-4">My Payments</h3>
    @if(count($payments) > 0)
        <table class="table table-bordered table-dark">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Total</th>
                    {{-- <th>Actions</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $pay)
                    <tr>
                        <td>{{ $pay->id }}</td>
                        <td>{{ $pay->created_at->format('d M Y') }}</td>
                        <td>{{ $pay->status }}</td>
                        <td>KSh {{ number_format($pay->amount, 2) }}</td>
                       
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>You have no Payment.</p>
    @endif
@endsection
