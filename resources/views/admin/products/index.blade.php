@extends('layouts.appbar')

@section('content')
    <!-- Content Wrapper -->
    <div class="content-wrapper">

        @include('flash_msg')
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center mb-3">
                    <div class="col-sm-6">
                        <h1 class="page-title">Products</h1>
                        <p class="text-muted">Manage and view all products available in the system</p>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm">
                            <i class="fas fa-plus"></i> Add Product
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Products List -->
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap">
                                <h3 class="card-title font-weight-bold mb-2 mb-md-0">Product List</h3>
                                <form action="{{ route('products.index') }}" method="GET" class="form-inline">
                                    <input type="text" name="query" class="form-control mr-2" placeholder="Search by product name..." value="{{ request('query') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                </form>
                            </div>

                            <!-- Product Table -->
                            <div class="card-body p-0">
                                <table class="table table-hover table-bordered table-responsive-md">
                                    @include('flash_msg')
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Price (KES)</th>
                                            <th>Google Merchant</th>
                                            <th>Category</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($products as $key => $product)
                                            <tr>
                                                <td>{{ $products->firstItem() + $key }}</td>
                                                <td>
                                                    <img class="default-img" src="{{ url('/') }}/storage/{{ $product->photo }}" style="width: 150px;" alt="">
                                                </td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->slug }}</td>
                                                <td>
                                                    {{ number_format($product->price, 2) }} 
                                                    (@if($product->has_price == 1)
                                                        has price
                                                    @else
                                                        get quote
                                                    @endif)
                                                </td>
                                                <td>{{ $product->google_merchant ? 'Yes' : 'No' }}</td>
                                                @php
                                                    $productCategory = $product->category_id ? category($product->category_id) : null;
                                                @endphp
                                                <td>{{ $productCategory?->name ?? 'Unassigned' }}</td>
                                                <td>
                                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i> Update
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#delete-product{{ $product->id }}">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Delete Product Modal -->
                                            <div class="modal fade" id="delete-product{{ $product->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete Product</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <p>Are you sure you want to delete this product?</p>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.modal -->
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">No products found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="card-footer bg-white d-flex justify-content-center">
                                {{ $products->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
