@extends('layouts.app')

@section('title', 'Ficha de la fase')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h1 class="h4">{{ $phase->name }}</h1>
        <p><strong>Encargo:</strong> {{ $phase->job?->name }}</p>
        <p><strong>Cliente:</strong> {{ $phase->job?->client?->name }} {{ $phase->job?->client?->surname }}</p>
        <p><strong>Responsable:</strong> {{ $phase->responsibleUser?->name }} {{ $phase->responsibleUser?->surname }}</p>
        <p><strong>Estado:</strong> {{ $phase->status }}</p>
        <p><strong>Fecha:</strong> {{ optional($phase->phase_date)->format('d/m/Y') }}</p>
        <p><strong>Horas:</strong> {{ $phase->hours_spent }}</p>
        <p><strong>Observaciones:</strong> {{ $phase->observations }}</p>
        <p><strong>Foto obligatoria:</strong> {{ $phase->requires_photo ? 'Sí' : 'No' }}</p>
        <p><strong>Vídeo obligatorio:</strong> {{ $phase->requires_video ? 'Sí' : 'No' }}</p>

        <h2 class="h5 mt-4">Materiales usados</h2>
        @forelse($phase->materials as $material)
            <div class="border rounded p-2 mb-2">
                {{ $material->name }} - {{ $material->unit_measurement }}
            </div>
        @empty
            <p>No hay materiales asignados.</p>
        @endforelse

        <a href="{{ route('phases.edit', $phase) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('phases.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection