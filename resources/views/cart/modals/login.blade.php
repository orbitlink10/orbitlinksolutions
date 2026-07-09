<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (session('registration_success'))
                    <div class="alert alert-success" role="alert">
                        {!! session('registration_success') !!}
                    </div>
                @endif

                <h3 class="authTitle text-center mb-4">Welcome Back</h3>
                @include('admin.flash_msg')

                <form action="{{ route('login_post_users') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Email">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                        <label class="form-check-label" for="rememberMe">Remember Me</label>
                    </div>

                    <button class="btn btn-primary w-100" type="submit">Login</button>

                    <div class="text-center mt-3">
                        <p class="mb-2">
                            <a href="{{ route('password.request') }}" class="btn btn-link p-0">Forgot your password?</a>
                        </p>
                        <p class="forgotPassword mb-0">
                            <button type="button" class="btn btn-link p-0" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">
                                New here? Create an Account
                            </button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
