@extends('layouts.app')

@section('title', 'Incidencias')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Incidencias</h1>
    <a href="{{ route('incidents.create') }}" class="btn btn-primary">Nueva incidencia</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>Encargo</th>
                    <th>Fase</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($incidents as $incident)
                    <tr>
                        <td>{{ $incident->job?->name }}</td>
                        <td>{{ $incident->phase?->name ?? '-' }}</td>
                        <td>{{ optional($incident->incident_date)->format('d/m/Y') }}</td>
                        <td>{{ $incident->status }}</td>
                        <td class="text-end">
                            <a href="{{ route('incidents.show', $incident) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('incidents.edit', $incident) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('incidents.destroy', $incident) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta incidencia?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Borrar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">No hay incidencias todavía.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $incidents->links() }}
    </div>
</div>
@endsection