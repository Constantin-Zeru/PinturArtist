@extends('layouts.guest')

@section('title', 'Recuperar contraseña')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-sm w-100" style="max-width: 520px;">
        <div class="card-body p-4">
            <h1 class="h4 mb-3">Recuperar contraseña</h1>

            <p class="text-muted">
                Escribe tu correo y te enviaremos un enlace para restablecer la contraseña.
            </p>

            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Enviar enlace
                </button>
            </form>

            <div class="mt-3 text-center">
                <a href="{{ route('login') }}">Volver al inicio de sesión</a>
            </div>
        </div>
    </div>
</div>
@endsection