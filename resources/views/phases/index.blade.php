@extends('layouts.app')

@section('title', 'Fases')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Fases</h1>
    <a href="{{ route('phases.create') }}" class="btn btn-primary">Nueva fase</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>Encargo</th>
                    <th>Cliente</th>
                    <th>Fase</th>
                    <th>Responsable</th>
                    <th>Estado</th>
                    <th>Horas</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($phases as $phase)
                    <tr>
                        <td>{{ $phase->job?->name }}</td>
                        <td>{{ $phase->job?->client?->name }} {{ $phase->job?->client?->surname }}</td>
                        <td>{{ $phase->name }}</td>
                        <td>{{ $phase->responsibleUser?->name }} {{ $phase->responsibleUser?->surname }}</td>
                        <td>{{ $phase->status }}</td>
                        <td>{{ $phase->hours_spent }}</td>
                        <td class="text-end">
                            <a href="{{ route('phases.show', $phase) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('phases.edit', $phase) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('phases.destroy', $phase) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta fase?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Borrar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay fases todavía.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $phases->links() }}
    </div>
</div>
@endsection