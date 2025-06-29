@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">🎉 Registration completed successfully!</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Well done!</h4>
                    <p>Hello <strong>{{ $user->first_name }}</strong>,</p>

                    <p>Thank you for registering with <strong>{{ $app_name }}</strong>!</p>

                    <p>To complete your account setup, please verify your email address by clicking the button below:</p>

                    <a href="{{ $verification_link }}" class="btn btn-success my-2" target="_blank">
                        👉 Verify My Email
                    </a>

                    <p class="mt-3">If the button above doesn’t work, copy and paste the following URL into your browser:</p>
                    <p class="small text-break"><code>{{ $verification_link }}</code></p>

                    <hr>
                    <p class="mb-0">If you did not create an account with us, please disregard this email.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
