@extends('theme.layouts.main')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0-beta3/css/bootstrap.min.css" rel="stylesheet">

@section('main')
    <!-- Page Header Start -->
    <section class="page-header bg-dark text-light py-5">
        <div class="page-header-bg" style="background-image: url('{{ asset('assets/images/backgrounds/page-header-bg.jpg') }}'); background-size: cover; background-position: center;"></div>
        <div class="container">
            <div class="page-header__inner">
                <ul class="breadcrumb list-unstyled d-flex">
                    <li class="breadcrumb-item"><a href="/" class="text-light">Home</a></li>
                    <li class="breadcrumb-item active text-light">Cart</li>
                </ul>
                <h2 class="page-header-title text-light">Cart</h2>
            </div>
        </div>
    </section>
    <!-- Page Header End -->

    <!-- Start Cart Page -->
    <section class="cart-page py-5 bg-dark text-light">
        <div class="container">
            @if($cart && count($cart) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered cart-table text-light">
                        <thead class="thead-dark">
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $subtotal = 0; @endphp
                            @foreach ($cart as $id => $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="img-box me-3">
                                                <img src="/images?path={{ $item['photo'] }}" alt="" class="img-fluid" width="100">
                                            </div>
                                            <h5 class="mb-0 text-light"><a href="#" class="text-light">{{ $item['name'] }}</a></h5>
                                        </div>
                                    </td>
                                    <td>KSh {{ number_format($item['price'], 2) }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <form action="{{ route('cart.update') }}" method="POST" class="d-flex">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <button type="submit" name="action" value="decrease" class="btn btn-sm btn-outline-secondary text-light me-2">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control text-center w-50 bg-dark text-light border-secondary" />
                                                <button type="submit" name="action" value="increase" class="btn btn-sm btn-outline-secondary text-light ms-2">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td>KSh {{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <button type="submit" class="btn btn-sm btn-danger text-light">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @php $subtotal += $item['price'] * $item['quantity']; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-lg-8"></div>
                    <div class="col-lg-4">
                        <ul class="list-group bg-dark text-light">
                            <li class="list-group-item d-flex justify-content-between bg-secondary text-light">
                                <span>Subtotal</span>
                                <span>KSh {{ number_format($subtotal, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between bg-secondary text-light">
                                <span>Shipping Cost</span>
                                <span>KSh 0.00</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between bg-secondary text-light">
                                <strong>Total</strong>
                                <strong>KSh {{ number_format($subtotal, 2) }}</strong>
                            </li>
                        </ul>
                        <div class="mt-3 d-flex justify-content-between">
                            @auth
                                <a href="{{ route('cart.checkout') }}" class="btn btn-primary">Proceed to Checkout</a>
                            @else
                                @if (session('registration_success'))
                                    <div class="alert alert-success">{!! session('registration_success') !!}</div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                                    Please login to proceed to checkout.
                                </button>

                                <!-- Login Modal -->
                                <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" >
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="loginModalLabel" style="color: #000000;">Login</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="login p-5 shadow-sm rounded" style="background: linear-gradient(to right, #000000, #000000);">
                                                    @if (session('registration_success'))
                                                        <div class="alert alert-success">{!! session('registration_success') !!}</div>
                                                    @endif

                                                    <h3 class="authTitle text-center mb-4">Login</h3>
                                                    @include('admin.flash_msg')
                                                    <form action="{{ route('login_post_users') }}" method="post" autocomplete="off">
                                                        @csrf
                                                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                                            <label for="email">Email</label>
                                                            <div class="input-group mb-3">
                                                            
                                                                <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Enter email">
                                                            </div>
                                                            {!! $errors->has('email') ? '<p class="text-danger">' . $errors->first('email') . '</p>' : '' !!}
                                                        </div>

                                                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                                            <label for="password">Password</label>
                                                            <div class="input-group mb-3">
                                                           
                                                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                                            </div>
                                                            {!! $errors->has('password') ? '<p class="text-danger">' . $errors->first('password') . '</p>' : '' !!}
                                                        </div>

                                                        <button class="btn btn-lg btn-warning btn-block mb-3" type="submit">Login</button>

                                                        <div class="form-check mb-3">
                                                            <input type="checkbox" class="form-check-input" id="rememberMe" value="remember-me">
                                                            <label class="form-check-label" for="rememberMe">Remember Me</label>
                                                        </div>

                                                        <div class="text-center">
                                                            <p class="forgotPassword mb-0">
                                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal">
                                                                    New Here, Create an Account
                                                                </button>
                                                            </p>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Register Modal -->
                                <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" style="color: #000000;" id="registerModalLabel">Register</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @if (session('error'))
                                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                                @endif

                                                <form action="{{ route('users.store_user') }}" method="post" role="form" style="color: #000000;">

                                                    @csrf
                                                    <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                                        <label for="first_name">First Name</label>
                                                        <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="Enter your first name">
                                                        {!! $errors->has('first_name') ? '<p class="text-danger">' . $errors->first('first_name') . '</p>' : '' !!}
                                                    </div>

                                                    <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                                        <label for="last_name">Last Name</label>
                                                        <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="Enter your last name">
                                                        {!! $errors->has('last_name') ? '<p class="text-danger">' . $errors->first('last_name') . '</p>' : '' !!}
                                                    </div>

                                                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                                        <label for="phone">Phone Number</label>
                                                        <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}" placeholder="Enter your phone number">
                                                        {!! $errors->has('phone') ? '<p class="text-danger">' . $errors->first('phone') . '</p>' : '' !!}
                                                    </div>

                                                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                                        <label for="email">Email Address</label>
                                                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Enter your email address">
                                                        {!! $errors->has('email') ? '<p class="text-danger">' . $errors->first('email') . '</p>' : '' !!}
                                                    </div>

                                                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                                        <label for="password">Password</label>
                                                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password">
                                                        {!! $errors->has('password') ? '<p class="text-danger">' . $errors->first('password') . '</p>' : '' !!}
                                                    </div>

                                                    <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                                        <label for="password_confirmation">Confirm Password</label>
                                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm your password">
                                                        {!! $errors->has('password_confirmation') ? '<p class="text-danger">' . $errors->first('password_confirmation') . '</p>' : '' !!}
                                                    </div>

                                                    <button type="submit" class="btn btn-lg btn-primary btn-block mb-3">Register</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center text-light">
                    <h4>Your cart is empty</h4>
                    <a href="{{ route('product') }}" class="btn btn-primary">Return to Shop</a>
                </div>
            @endif
        </div>
    </section>
    <!-- End Cart Page -->
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0-beta3/js/bootstrap.min.js"></script>
@endsection
