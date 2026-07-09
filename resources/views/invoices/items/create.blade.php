@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="page-title">Add Items to Invoice</h1>
                <p class="text-muted">Invoice: {{ $invoice->name }}</p>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <!-- Form to Add New Item -->
                        <form action="{{ route('invoice.items.store', $invoice->id) }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="description">Item Description:</label>
                                <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="amount">Amount:</label>
                                <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" step="0.01" required>
                            </div>

                            <button type="submit" class="btn btn-primary shadow-sm">Add Item</button>
                            <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-secondary shadow-sm">Back to Invoice</a>
                        </form>
                    </div>
                </div>

                <!-- Display Existing Items -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold">Existing Items</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover table-bordered mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoice->items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ number_format($item->amount, 2) }}</td>
                                        <td>
                                            <!-- Optional Edit/Delete Actions -->
                                            <form action="{{ route('invoice.items.destroy', [$invoice->id, $item->id]) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No items added yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
