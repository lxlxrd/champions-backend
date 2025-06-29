@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="alert alert-success text-center">
            ✅ Your email address has been successfully verified.<br>
            You will be redirected in a few seconds...
        </div>
    </div>

    <script>
        setTimeout(() => {
            window.location.href = "{{ $redirect_url }}";
        }, 3000); // redirige après 3 secondes
    </script>
@endsection
