@extends('layouts.app')

@section('title', 'Ficha de incidencia')

@section('content')
<div class="card shadow-sm"><div class="card-body">
    <h1 class="h4">Incidencia</h1>
    <p><strong>Encargo:</strong> {{ $incident->job?->name }}</p>
    <p><strong>Fase:</strong> {{ $incident->phase?->name ?? '-' }}</p>
    <p><strong>Causa:</strong> {{ $incident->cause }}</p>
    <p><strong>Fecha:</strong> {{ optional($incident->incident_date)->format('d/m/Y') }}</p>
    <p><strong>Solución:</strong> {{ $incident->resolution ?? '-' }}</p>
    <p><strong>Retraso:</strong> {{ $incident->delay_minutes ?? 0 }} minutos</p>
    <p><strong>Estado:</strong> {{ $incident->status }}</p>
    <p><strong>Afecta presupuesto:</strong> {{ $incident->affects_budget ? 'Sí' : 'No' }}</p>
    <p><strong>Afecta fecha final:</strong> {{ $incident->affects_deadline ? 'Sí' : 'No' }}</p>

    <a href="{{ route('incidents.edit', $incident) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('incidents.index') }}" class="btn btn-secondary">Volver</a>
</div></div>
@endsection