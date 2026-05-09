@extends('layouts.app')

@section('title', 'Ficha del material')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h1 class="h4">{{ $material->name }}</h1>
        <p><strong>Unidad:</strong> {{ $material->unit_measurement }}</p>
        <p><strong>Cantidad:</strong> {{ $material->available_quantity }}</p>
        <p><strong>Coste:</strong> {{ $material->cost }}</p>
        <p><strong>Proveedor:</strong> {{ $material->provider }}</p>
        <p><strong>Notas:</strong> {{ $material->notes }}</p>
        <p><strong>Activo:</strong> {{ $material->active ? 'Sí' : 'No' }}</p>

        <a href="{{ route('materials.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection