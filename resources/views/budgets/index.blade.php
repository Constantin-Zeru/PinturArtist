@extends('layouts.app')

@section('title', 'Presupuestos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="h3 mb-0">Presupuestos</h1>
        <p class="text-muted mb-0">Listado de presupuestos base y su estado actual</p>
    </div>

    @if(auth()->user()->role === 'administrador')
        <a href="{{ route('budgets.create') }}" class="btn btn-primary">Nuevo presupuesto</a>
    @endif
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Encargo</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th>Base</th>
                        <th>Cambios aprobados</th>
                        <th>Final</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($budgets as $budget)
                        <tr>
                            <td class="fw-semibold">{{ $budget->job?->name }}</td>
                            <td>{{ $budget->job?->client?->name }} {{ $budget->job?->client?->surname }}</td>
                            <td>{{ $budget->status }}</td>
                            <td>{{ number_format($budget->estimated_total, 2) }} €</td>
                            <td>{{ number_format($budget->approved_changes_total, 2) }} €</td>
                            <td>{{ number_format($budget->final_total, 2) }} €</td>
                            <td class="text-end">
                                <a href="{{ route('budgets.show', $budget) }}" class="btn btn-sm btn-info">Ver</a>

                                @if(auth()->user()->role === 'administrador')
                                    <a href="{{ route('budgets.edit', $budget) }}" class="btn btn-sm btn-warning">Editar</a>

                                    <form action="{{ route('budgets.destroy', $budget) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Eliminar este presupuesto?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Borrar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No hay presupuestos todavía.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $budgets->links() }}
        </div>
    </div>
</div>
@endsection