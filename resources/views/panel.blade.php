@extends('layouts.app')

@section('title', 'Panel principal')

@section('content')
<div class="mb-4">
    <p class="text-muted mb-0">Panel principal de gestión de la tienda de pintura</p>
</div>

@if($role === 'administrador')
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm stat-card">
                <div class="card-body d-flex flex-column">
                    <div class="text-muted">Clientes</div>
                    <div class="fs-3 fw-bold">{{ $clientsCount }}</div>
                    <a href="{{ route('clients.index') }}" class="btn btn-primary btn-sm mt-3">Abrir</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm stat-card">
                <div class="card-body d-flex flex-column">
                    <div class="text-muted">Encargos</div>
                    <div class="fs-3 fw-bold">{{ $jobsCount }}</div>
                    <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-sm mt-3">Abrir</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm stat-card">
                <div class="card-body d-flex flex-column">
                    <div class="text-muted">Presupuestos</div>
                    <div class="fs-3 fw-bold">{{ $budgetsCount }}</div>
                    <a href="{{ route('budgets.index') }}" class="btn btn-primary btn-sm mt-3">Abrir</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm stat-card">
                <div class="card-body d-flex flex-column">
                    <div class="text-muted">Fases</div>
                    <div class="fs-3 fw-bold">{{ $phasesCount }}</div>
                    <a href="{{ route('phases.index') }}" class="btn btn-primary btn-sm mt-3">Abrir</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mt-3">
            <div class="card shadow-sm stat-card">
                <div class="card-body d-flex flex-column">
                    <div class="text-muted">Galería</div>
                    <div class="fs-3 fw-bold">{{ $galleryCount }}</div>
                    <a href="{{ route('gallery.index') }}" class="btn btn-info btn-sm mt-3">Abrir</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mt-3">
            <div class="card shadow-sm stat-card">
                <div class="card-body d-flex flex-column">
                    <div class="text-muted">Incidencias</div>
                    <div class="fs-3 fw-bold">{{ $incidentsCount }}</div>
                    <a href="{{ route('incidents.index') }}" class="btn btn-danger btn-sm mt-3">Abrir</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mt-3">
            <div class="card shadow-sm stat-card">
                <div class="card-body d-flex flex-column">
                    <div class="text-muted">Materiales</div>
                    <div class="fs-3 fw-bold">{{ $materialsCount }}</div>
                    <a href="{{ route('materials.index') }}" class="btn btn-success btn-sm mt-3">Abrir</a>
                </div>
            </div>
        </div>
    </div>
@endif

@if($role === 'trabajador')
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm stat-card">
                <div class="card-body d-flex flex-column">
                    <div class="text-muted">Mis encargos</div>
                    <div class="fs-3 fw-bold">{{ $jobsCount }}</div>
                    <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-sm mt-3">Abrir</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm stat-card">
                <div class="card-body d-flex flex-column">
                    <div class="text-muted">Mis fases</div>
                    <div class="fs-3 fw-bold">{{ $phasesCount }}</div>
                    <a href="{{ route('phases.index') }}" class="btn btn-success btn-sm mt-3">Abrir</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm stat-card">
                <div class="card-body d-flex flex-column">
                    <div class="text-muted">Mis archivos</div>
                    <div class="fs-3 fw-bold">{{ $galleryCount }}</div>
                    <a href="{{ route('gallery.index') }}" class="btn btn-info btn-sm mt-3">Abrir</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm stat-card">
                <div class="card-body d-flex flex-column">
                    <div class="text-muted">Mis incidencias</div>
                    <div class="fs-3 fw-bold">{{ $incidentsCount }}</div>
                    <a href="{{ route('incidents.index') }}" class="btn btn-danger btn-sm mt-3">Abrir</a>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <h2 class="h5 mb-3">Encargos recientes</h2>

        @forelse($recentJobs as $job)
            <div class="border-bottom py-2">
                <strong>{{ $job->name }}</strong><br>
                <small class="text-muted">
                    {{ $job->client?->name }} {{ $job->client?->surname }} · {{ $job->status }}
                </small>
            </div>
        @empty
            <p class="mb-0">No hay encargos todavía.</p>
        @endforelse
    </div>
</div>
@endsection