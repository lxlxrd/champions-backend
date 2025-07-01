@extends('layouts.app')

@section('content')
    <style>
        .full-height-center {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <div class="full-height-center bg-light">
        <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
            <h4 class="text-center mb-4">Create your admin account</h4>

            {{-- Affichage des erreurs --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Affichage du message de succès --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ url('/admin/create') }}" autocomplete="off">
                @csrf
                <div class="mb-3">
                    <input type="text" name="first_name" class="form-control" placeholder="First Name" required
                        value="{{ old('first_name') }}">
                </div>
                <div class="mb-3">
                    <input type="text" name="last_name" class="form-control" placeholder="Last Name" required
                        value="{{ old('last_name') }}">
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required
                        autocomplete="off" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <input type="text" name="address" class="form-control" placeholder="Address" required
                        value="{{ old('address') }}">
                </div>
                <div class="mb-3">
                    <input type="text" name="phone" class="form-control" placeholder="Phone" required
                        value="{{ old('phone') }}">
                </div>
                {{-- Password --}}
                <div class="mb-3 position-relative">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password"
                        required autocomplete="new-password">
                    <span class="position-absolute top-50 end-0 translate-middle-y pe-3"
                        onclick="togglePassword('password', 'iconPassword')" style="cursor: pointer;">
                        <i class="fa fa-eye" id="iconPassword"></i>
                    </span>
                </div>

                {{-- Confirm Password --}}
                <div class="mb-3 position-relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                        placeholder="Confirm Password" required autocomplete="new-password">
                    <span class="position-absolute top-50 end-0 translate-middle-y pe-3"
                        onclick="togglePassword('password_confirmation', 'iconConfirm')" style="cursor: pointer;">
                        <i class="fa fa-eye" id="iconConfirm"></i>
                    </span>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Sign up</button>
                </div>
            </form>

        </div>
    </div>


    {{-- Reveal password --}}
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>

@endsection
