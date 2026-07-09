@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="page-title">Edit Invoice</h1>
                <p class="text-muted">Update the details of the invoice</p>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <!-- Form to Edit Invoice -->
                        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                  

                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $invoice->name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="currency">Currency:</label>
                                <input type="text" class="form-control" id="currency" name="currency" value="{{ $invoice->currency }}" required>
                            </div>


                            <div class="form-group">
    <label for="due_date">Due Date</label>
    <input type="date" id="due_date" name="due_date" class="form-control" value="{{ old('due_date', $invoice->due_date ?? '') }}">
</div>

<div class="form-group">
    <label for="status">Status</label>
    <select id="status" name="status" class="form-control">
        <option value="pending" {{ (old('status', $invoice->status ?? 'pending') == 'pending') ? 'selected' : '' }}>Pending</option>
        <option value="paid" {{ (old('status', $invoice->status ?? 'pending') == 'paid') ? 'selected' : '' }}>Paid</option>
        <option value="overdue" {{ (old('status', $invoice->status ?? 'pending') == 'overdue') ? 'selected' : '' }}>Overdue</option>
    </select>
</div>


                            <button type="submit" class="btn btn-primary shadow-sm">Update</button>
                            <a href="{{ route('invoices.index') }}" class="btn btn-secondary shadow-sm">Cancel</a>
                        </form>
                    </div>
                </div>

                <!-- Display and Manage Invoice Items -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold">Invoice Items</h3>
                        <div class="text-right">
                            <a href="{{ route('invoice.items.create', $invoice->id) }}" class="btn btn-primary shadow-sm">
                                <i class="fas fa-plus"></i> Add Item
                            </a>
                        </div>
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
