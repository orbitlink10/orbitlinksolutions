@extends('theme.electro.layouts.main')

@section('main')

<!-- Breadcrumb/Header -->
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ url('/') }}" rel="nofollow">Home</a>
            <span></span> Checkout
        </div>
    </div>
  </div>

<!--Start Checkout Page-->
<section class="checkout-page py-5">
    <div class="container">
        @if (count($cart) > 0)
            <form action="{{ route('store_order') }}" method="POST" class="row g-4">
                @csrf
                <div class="col-lg-7">
                    <div class="card shadow-sm p-4 h-100">
                        <h4 class="fw-bold text-dark mb-3">Billing Details</h4>
                        <div class="row g-3">
                            <div class="col-12 d-none">
                                <label for="company_name" class="form-label">Company Name (Optional)</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name') }}">
                            </div>

                            <div class="col-12">
                                <label for="county_id" class="form-label">County</label>
                                <select class="form-select" id="county_id" name="county_id">
                                    <option value="">Select county</option>
                                    @foreach(\App\Models\County::orderBy('name', 'asc')->get() as $county)
                                        <option value="{{ $county->id }}">{{ $county->name }}</option>
                                    @endforeach
                                </select>
                                @error('county_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Address (Your location)</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                                @error('address')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card shadow-sm p-4">
                        <h4 class="fw-bold text-dark mb-3">Your Order</h4>
                        <table class="table align-middle mb-3">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-end">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $subtotal = 0;
                                @endphp
                                @foreach ($cart as $item)
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td class="text-end">KSh {{ number_format($item['price'], 2) }}</td>

                                        <input type="hidden" name="product_ids[]" value="{{ $item['id'] }}">
                                        <input type="hidden" name="quantities[]" value="{{ $item['quantity'] }}">
                                    </tr>
                                    @php
                                        $subtotal += $item['price'] * $item['quantity'];
                                    @endphp
                                @endforeach
                                <tr>
                                    <td><strong>Subtotal</strong></td>
                                    <td class="text-end"><strong>KSh {{ number_format($subtotal, 2) }}</strong></td>
                                </tr>

                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td class="text-end"><strong>KSh {{ number_format($subtotal, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>

                        <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                        <input type="hidden" name="total" value="{{ $subtotal }}">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-accent btn-lg">Place your order</button>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <div class="text-center">
                <h2>Your cart is empty</h2>
                <p class="lead">It looks like you haven't added any products to your cart yet.</p>
                <a href="{{ url('shop') }}" class="btn btn-accent">Continue Shopping</a>
            </div>
        @endif
    </div>
</section>
<!--End Checkout Page-->
@endsection
