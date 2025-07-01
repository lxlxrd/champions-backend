@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
            <h4 class="text-center f-w-500 mb-3">Login with your email</h4>
            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                {{-- Email --}}
                <div class="form-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group mb-3 position-relative">
                    <input type="password" id="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                    <span class="position-absolute top-50 end-0 translate-middle-y pe-3" onclick="togglePassword()"
                        style="cursor: pointer;">
                        <i class="fa fa-eye" id="togglePasswordIcon"></i>
                    </span>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                {{-- Remember Me + Forgot --}}
                <div class="d-flex mt-1 justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input input-primary" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-muted" for="remember">Remember me?</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-secondary f-w-400 mb-0">Forgot Password?</a>
                </div>

                {{-- Submit --}}
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>

                {{-- Link to register (si nécessaire plus tard) --}}
                {{-- <div class="d-flex justify-content-between align-items-end mt-4">
                <h6 class="f-w-500 mb-0">Don't have an Account?</h6>
                <a href="#" class="link-primary">Create Account</a>
            </div> --}}
            </form>
        </div>
        @push('scripts')
            <script>
                function togglePassword() {
                    const passwordInput = document.getElementById("password");
                    const icon = document.getElementById("togglePasswordIcon");
                    const isPassword = passwordInput.type === "password";

                    passwordInput.type = isPassword ? "text" : "password";
                    icon.classList.toggle("fa-eye");
                    icon.classList.toggle("fa-eye-slash");
                }
            </script>
        @endpush

    </div>
@endsection
