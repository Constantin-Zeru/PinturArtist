@php
    $role = auth()->check() ? auth()->user()->role : null;
@endphp

@if(auth()->check())
    <ul class="nav nav-pills flex-column gap-1">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('panel') ? 'active' : '' }}" href="{{ route('panel') }}">Panel</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('jobs.*') ? 'active' : '' }}" href="{{ route('jobs.index') }}">Encargos</a>
        </li>

        @if($role === 'administrador')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}" href="{{ route('clients.index') }}">Clientes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('budgets.*') ? 'active' : '' }}" href="{{ route('budgets.index') }}">Presupuestos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('materials.*') ? 'active' : '' }}" href="{{ route('materials.index') }}">Materiales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('workers.*') ? 'active' : '' }}" href="{{ route('workers.index') }}">Trabajadores</a>
            </li>
        @endif

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('phases.*') ? 'active' : '' }}" href="{{ route('phases.index') }}">Fases</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}" href="{{ route('gallery.index') }}">Galería</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('incidents.*') ? 'active' : '' }}" href="{{ route('incidents.index') }}">Incidencias</a>
        </li>
    </ul>

    <hr class="border-secondary my-3">
@endif