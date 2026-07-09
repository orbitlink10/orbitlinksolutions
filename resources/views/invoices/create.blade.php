@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="page-title">Create Invoice</h1>
                <p class="text-muted">Add a new invoice to the system</p>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('invoices.store') }}" method="POST">
                            @csrf



                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="currency">Currency:</label>
                                <input type="text" class="form-control" id="currency" name="currency" value="{{ old('currency', 'KES') }}" required>
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


                            <button type="submit" class="btn btn-primary shadow-sm">Create Invoice</button>
                            <a href="{{ route('invoices.index') }}" class="btn btn-secondary shadow-sm">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();
        fetch(this.action, {
            method: this.method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify(Object.fromEntries(new FormData(this))),
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Error creating invoice.');
            }
        })
        .then(data => {
            window.location.href = `/invoices/${data.id}/items`;
        })
        .catch(error => {
            alert(error.message);
        });
    });
</script>
@endpush
