@extends('layouts.app')

@section('title', 'Ficha del encargo')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h1 class="h4">{{ $job->name }}</h1>
        <p><strong>Cliente:</strong> {{ $job->client?->name }} {{ $job->client?->surname }}</p>
        <p><strong>Tipo:</strong> {{ $job->work_type }}</p>
        <p><strong>Estado técnico:</strong> {{ $job->technical_state }}</p>
        <p><strong>Estado:</strong> {{ $job->status }}</p>
        <p><strong>Prioridad:</strong> {{ $job->priority }}</p>
        <p><strong>Superficie:</strong> {{ $job->surface_m2 }} m²</p>
        <p><strong>Estancias:</strong> {{ $job->rooms_count }}</p>
        <p><strong>Altura:</strong> {{ $job->height_m }} m</p>
        <p><strong>Solicitud:</strong> {{ optional($job->requested_at)->format('d/m/Y') }}</p>
        <p><strong>Inicio previsto:</strong> {{ optional($job->planned_start_at)->format('d/m/Y') }}</p>
        <p><strong>Fin previsto:</strong> {{ optional($job->planned_end_at)->format('d/m/Y') }}</p>
        <p><strong>Descripción:</strong> {{ $job->description }}</p>
        <p><strong>Observaciones técnicas:</strong> {{ $job->technical_observations }}</p>

        <p class="mb-2"><strong>Trabajadores asignados:</strong></p>
        @forelse($job->users as $worker)
            <span class="badge bg-info text-dark me-1 mb-1">
                {{ $worker->name }} {{ $worker->surname }}
            </span>
        @empty
            <span class="text-muted">Sin asignar</span>
        @endforelse

        <div class="mt-4">
            @if(auth()->user()->role === 'administrador')
                <a href="{{ route('jobs.edit', $job) }}" class="btn btn-warning">Editar</a>
            @endif
            <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
@endsection