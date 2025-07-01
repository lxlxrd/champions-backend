@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
            <h4 class="text-center mb-3">Forgot your password?</h4>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <p class="text-muted text-center">Enter your email address and we'll send you a link to reset your password.</p>

            {{-- @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif --}}


            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
                </div>
            </form>
        </div>
    </div>
@endsection
