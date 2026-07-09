@extends('theme.orbit.layouts.main')

@section('main')
@php
    $currency = get_option('currency_symbol', 'KSh');
@endphp
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ url('/') }}" rel="nofollow">Home</a>
                <span></span> Cart
            </div>
        </div>
    </div>

    <section class="cart-page">
        <div class="container">
            @if (session('registration_success'))
                <div class="alert alert-success cart-alert">{!! session('registration_success') !!}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger cart-alert">{{ session('error') }}</div>
            @endif

            @if($cart && count($cart) > 0)
                <div class="cart-header">
                    <div>
                        <h1>Shopping Cart</h1>
                        <p class="text-muted">Review your items and proceed to checkout when ready.</p>
                    </div>
                    <a href="{{ url('shop') }}" class="btn btn-outline-secondary">Continue Shopping</a>
                </div>

                <div class="cart-layout">
                    <div class="cart-items">
                        @php $subtotal = 0; @endphp
                        @foreach ($cart as $id => $item)
                            <div class="cart-row">
                                <div class="cart-product">
                                    <div class="cart-thumb">
                                        <img src="{{ url('/') }}/storage/{{ $item['photo'] }}" alt="{{ $item['name'] }}" loading="lazy">
                                    </div>
                                    <div class="cart-product-info">
                                        @if(!empty($item['slug']))
                                            <a href="{{ route('product_details', $item['slug']) }}" class="cart-title">{{ $item['name'] }}</a>
                                        @else
                                            <span class="cart-title">{{ $item['name'] }}</span>
                                        @endif
                                        <div class="cart-price">{{ $currency }} {{ number_format($item['price'], 2) }} each</div>
                                    </div>
                                </div>
                                <div class="cart-qty">
                                    <form action="{{ route('cart.update') }}" method="POST" class="cart-qty-form">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" name="action" value="decrease" class="btn btn-outline-secondary" aria-label="Decrease quantity">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control text-center" />
                                        <button type="submit" name="action" value="increase" class="btn btn-outline-secondary" aria-label="Increase quantity">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="cart-line-total">{{ $currency }} {{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                                <div class="cart-remove">
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" class="btn btn-danger" aria-label="Remove item">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @php $subtotal += $item['price'] * $item['quantity']; @endphp
                        @endforeach
                    </div>

                    <aside class="cart-summary">
                        <div class="summary-card">
                            <h4>Order Summary</h4>
                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span>{{ $currency }} {{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="summary-row">
                                <span>Shipping</span>
                                <span>{{ $currency }} 0.00</span>
                            </div>
                            <div class="summary-total">
                                <span>Total</span>
                                <span>{{ $currency }} {{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="summary-actions">
                                @auth
                                    <a href="{{ route('cart.checkout') }}" class="btn btn-accent">Proceed to Checkout</a>
                                @else
                                    <button type="button" class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#registerModal">
                                        Proceed to Checkout
                                    </button>
                                    @include('cart.modals.login')
                                    @include('cart.modals.register')
                                @endauth
                            </div>
                            <p class="summary-note">Secure checkout and quick delivery options available.</p>
                        </div>
                    </aside>
                </div>
            @else
                <div class="cart-empty">
                    <i class="fas fa-shopping-cart"></i>
                    <h4>Your cart is empty</h4>
                    <p class="text-muted">Browse the store and add items to get started.</p>
                    <a href="{{ url('shop') }}" class="btn btn-accent">Return to Shop</a>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
@endsection
