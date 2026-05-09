@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-sm w-100" style="max-width: 420px;">
        <div class="card-body p-4">
            <h1 class="h4 mb-4 text-center">Acceso al sistema</h1>

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="remember" value="1" id="remember">
                    <label class="form-check-label" for="remember">Recordarme</label>
                </div>

                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>

            <div class="mt-3 text-center">
                <a href="{{ route('password.request') }}">¿Has olvidado tu contraseña?</a>
            </div>
        </div>
    </div>
</div>
@endsection