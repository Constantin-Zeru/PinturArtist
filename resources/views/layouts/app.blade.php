<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PinturArtist')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body>

@php
    $role = auth()->check() ? auth()->user()->role : null;
@endphp

<button class="mobile-menu-toggle d-lg-none" type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#mobileSidebar"
        aria-controls="mobileSidebar">
    Menú
</button>

<div class="offcanvas offcanvas-start app-mobile-sidebar text-bg-dark" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
    <div class="offcanvas-header">
        <div class="sidebar-mini w-100">
            <div class="sidebar-mini-label">Gestión interna</div>
            <div class="sidebar-mini-user">
                {{ $role === 'administrador' ? 'Admin Principal' : 'Trabajador' }}
            </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>

    <div class="offcanvas-body">
        @include('layouts.sidebar-links')
    </div>
</div>

<div class="app-layout d-flex">
    <aside class="sidebar d-none d-lg-flex flex-column">
        <div class="sidebar-mini m-3">
            <div class="sidebar-mini-label">Gestión interna</div>
            <div class="sidebar-mini-user">
                {{ $role === 'administrador' ? 'Admin Principal' : 'Trabajador' }}
            </div>
        </div>

        <div class="sidebar-menu px-3">
            @include('layouts.sidebar-links')
        </div>

        <div class="sidebar-footer mt-auto p-3 pt-0">
            <a href="{{ route('logout') }}"
               class="btn btn-danger w-100"
               onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();">
                Salir
            </a>
            <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </aside>

    <div class="app-page flex-grow-1">
        <header class="app-hero">
            <div class="app-hero-content">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo PinturArtist" class="app-hero-logo">
                <h1 class="app-hero-title">PinturArtist</h1>
            </div>
        </header>

        <main class="content-wrap">
            <div class="container-fluid py-4 px-3 px-lg-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>