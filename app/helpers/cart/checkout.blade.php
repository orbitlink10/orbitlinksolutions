@extends('theme.layouts.main')



@section('main')


<style>
    /* Dark Theme Input Styles */
    .form-control-dark {
        background-color: #343a40; /* Dark background color */
        color: #ffffff; /* White text color */
        border: 1px solid #495057; /* Dark border color */
    }

    .form-control-dark:focus {
        background-color: #495057; /* Slightly lighter background on focus */
        color: #ffffff; /* White text color */
        border-color: #80bdff; /* Bootstrap focus border color */
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25); /* Focus shadow */
    }

    .form-control-dark-textarea {
        background-color: #343a40; /* Dark background color for textareas */
        color: #ffffff; /* White text color */
        border: 1px solid #495057; /* Dark border color */
    }

    .form-control-dark-textarea:focus {
        background-color: #495057; /* Slightly lighter background on focus */
        color: #ffffff; /* White text color */
        border-color: #80bdff; /* Bootstrap focus border color */
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25); /* Focus shadow */
    }

    .text-danger {
        font-size: 0.875rem; /* Adjust error text size */
    }
</style>
 


    <!--Start Checkout Page-->
    <section class="checkout-page py-5" style="margin-top: 100px;">
        <div class="container">
            @if (count($cart) > 0)
                <form action="{{ route('store_order') }}" method="POST" class="row">
                    @csrf
                    <div class="col-lg-7">
                        <div class="mb-4">
                            <h4>Billing Details</h4>
                            <div class="row g-3">
                          
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="company_name">Company Name (Optional)</label>
                                        <input type="text" class="form-control form-control-dark" id="company_name" name="company_name" value="{{ old('company_name') }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="county_id">County</label>
                                        <select class="form-control form-control-dark" id="county_id" name="county_id" >
                                        <option>Select county</option>
                                            @foreach(\App\Models\County::orderBy('name', 'asc')->get() as $county)
                               
                                            <option value="{{ $county->id }}">{{ $county->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('county_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="address">Address (Your location)</label>
                                        <input type="text" class="form-control form-control-dark" id="address" name="address" value="{{ old('address') }}" required>
                                        @error('address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                        

                  

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="mb-4">
                            <h4>Your Order</h4>
                            <table class="table">
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
                        </div>

                        <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                        <input type="hidden" name="total" value="{{ $subtotal }}">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Place your order</button>
                        </div>
                    </div>
                </form>
            @else
                <div class="text-center">
                    <h2>Your cart is empty</h2>
                    <p class="lead">It looks like you haven't added any products to your cart yet.</p>
                    <a href="{{ route('product') }}" class="btn btn-primary">Continue Shopping</a>
                </div>
            @endif
        </div>
    </section>
    <!--End Checkout Page-->
@endsection
