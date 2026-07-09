@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="page-title">Invoices</h1>
                <p class="text-muted">View, manage, and track all invoices</p>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Invoices List Section -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title font-weight-bold">Invoice List</h3>
                        <a href="{{ route('invoices.create') }}" class="btn btn-primary shadow-sm">
                            <i class="fas fa-plus"></i> Create Invoice
                        </a>
                    </div>

                    <div class="card-body p-0">
                        @forelse($invoices as $index => $invoice)
                            <div class="row align-items-center border-bottom p-3">
                                <!-- Invoice Index -->
                                <div class="col-md-1 col-sm-2">
                                    <strong>#:</strong> {{ $index + 1 }}
                                </div>

                                <!-- Invoice Slug -->
                                <div class="col-md-2 col-sm-4">
                                    <strong>Slug:</strong> {{ $invoice->slug }}
                                </div>

                                <!-- Invoice Name -->
                                <div class="col-md-3 col-sm-6">
                                    <strong>Name:</strong> {{ $invoice->name }}
                                </div>

                                <!-- Total Amount -->
                                <div class="col-md-2 col-sm-6">
                                    <strong>Total:</strong> {{ $invoice->currency }} {{ number_format($invoice->items->sum('amount'), 2) }}
                                </div>

                                <!-- Actions -->
                                <div class="col-md-4 col-sm-12 text-md-right text-sm-left mt-sm-2 mt-md-0">
                                    <a target="_blank" href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this invoice?')">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                    <a href="{{ route('invoices.open', $invoice->slug) }}" class="btn btn-sm btn-outline-success" target="_blank">
                                        <i class="fas fa-file-invoice"></i> Open
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-muted">
                                No invoices available.
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer bg-white d-flex justify-content-center">
                        {{ $invoices->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
