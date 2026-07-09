@extends('layouts.appbar')
@section('content')
<div class="content-wrapper p-4">
    <h3 class="mb-4 text-dark">My Payments</h3>
    @if(count($payments) > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Payment ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $pay)
                        <tr>
                            <td>{{ $pay->id }}</td>
                            <td>{{ $pay->created_at->format('d M Y') }}</td>
                            <td>
                                <span class="badge 
                                    {{ $pay->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($pay->status) }}
                                </span>
                            </td>
                            <td>KSh {{ number_format($pay->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-warning text-center" role="alert">
            <p>You have no payments at the moment.</p>
        </div>
    @endif
</div>
@endsection
