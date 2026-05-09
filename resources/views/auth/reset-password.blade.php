@extends('layouts.guest')

@section('title', 'Nueva contraseña')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-sm w-100" style="max-width: 520px;">
        <div class="card-body p-4">
            <h1 class="h4 mb-3">Establecer nueva contraseña</h1>

            <p class="text-muted">
                Introduce tu nueva contraseña para finalizar el cambio.
            </p>

            <form action="{{ route('password.store') }}" method="POST">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ old('email', $email) }}">

                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" value="{{ old('email', $email) }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nueva contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    Cambiar contraseña
                </button>
            </form>
        </div>
    </div>
</div>
@endsection