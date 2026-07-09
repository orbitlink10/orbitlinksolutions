@extends('layouts.appbar')

@section('title', 'Edit Notification')

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Notification</h1>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('notifications.index') }}" class="btn btn-secondary">Back to Notifications</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Modify the details of the notification</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('notifications.update', $notification) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Email Field -->
                        <div class="form-group mb-3">
                            <label for="email">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email', $notification->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Phone Field -->
                        <div class="form-group mb-3">
                            <label for="phone">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{ old('phone', $notification->phone) }}" required>
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Product Field -->
                        <div class="form-group mb-3">
                            <label for="product_id">Product (Optional)</label>
                            <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror">
                                <option value="">Select a product (Optional)</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id', $notification->product_id) == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-primary">Update Notification</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
