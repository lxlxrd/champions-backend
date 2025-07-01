@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
            <h4 class="text-center mb-3">Reset Password</h4>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror


            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ request('email') }}">

                <div class="form-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="New Password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password"
                        required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection
