@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="page-title">Invoice Details</h1>
                <p class="text-muted">View detailed information about the selected invoice</p>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h3 class="mb-4">Invoice Information</h3>

                        <div class="mb-3">
                            <strong>Slug:</strong> {{ $invoice->slug }}
                        </div>
                        <div class="mb-3">
                            <strong>Name:</strong> {{ $invoice->name }}
                        </div>
                        <div class="mb-3">
                            <strong>Currency:</strong> {{ $invoice->currency }}
                        </div>

                        <h4 class="mt-4">Invoice Items</h4>
                        <table class="table table-hover table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoice->items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ number_format($item->amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No items found for this invoice.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <a href="{{ route('invoices.index') }}" class="btn btn-secondary shadow-sm">Back to List</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
