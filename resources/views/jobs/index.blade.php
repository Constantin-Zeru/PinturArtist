@extends('layouts.app')

@section('title', 'Encargos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Encargos</h1>
        <p class="text-muted mb-0">Listado general de trabajos y su estado actual</p>
    </div>

    @if(auth()->user()->role === 'administrador')
        <a href="{{ route('jobs.create') }}" class="btn btn-primary">Nuevo encargo</a>
    @endif
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="min-width: 160px;">Nombre</th>
                        <th style="min-width: 150px;">Cliente</th>
                        <th style="min-width: 110px;">Tipo</th>
                        <th style="min-width: 120px;">Estado técnico</th>
                        <th style="min-width: 120px;">Estado</th>
                        <th style="min-width: 100px;">Prioridad</th>
                        <th style="min-width: 180px;">Trabajadores</th>
                        <th class="text-end text-nowrap" style="min-width: 180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                        @php
                            $workers = $job->users;
                            $shownWorkers = $workers->take(2);
                            $remainingWorkers = max(0, $workers->count() - $shownWorkers->count());
                        @endphp

                        <tr>
                            <td class="fw-semibold text-nowrap">{{ $job->name }}</td>
                            <td class="text-nowrap">{{ $job->client?->name }} {{ $job->client?->surname }}</td>
                            <td class="text-nowrap">{{ $job->work_type }}</td>
                            <td class="text-nowrap">
                                @if($job->technical_state === 'nuevo')
                                    <span class="badge bg-success">Nuevo</span>
                                @elseif($job->technical_state === 'regular')
                                    <span class="badge bg-warning text-dark">Regular</span>
                                @else
                                    <span class="badge bg-danger">Malo</span>
                                @endif
                            </td>
                            <td class="text-nowrap">
                                @if($job->status === 'pendiente')
                                    <span class="badge bg-secondary">Pendiente</span>
                                @elseif($job->status === 'aceptado')
                                    <span class="badge bg-primary">Aceptado</span>
                                @elseif($job->status === 'en_proceso')
                                    <span class="badge bg-info text-dark">En proceso</span>
                                @elseif($job->status === 'pausado')
                                    <span class="badge bg-warning text-dark">Pausado</span>
                                @elseif($job->status === 'finalizado')
                                    <span class="badge bg-success">Finalizado</span>
                                @else
                                    <span class="badge bg-danger">Cancelado</span>
                                @endif
                            </td>
                            <td class="text-nowrap">
                                @if($job->priority === 'alta')
                                    <span class="badge bg-danger">Alta</span>
                                @elseif($job->priority === 'media')
                                    <span class="badge bg-warning text-dark">Media</span>
                                @else
                                    <span class="badge bg-info text-dark">Baja</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse($shownWorkers as $worker)
                                        <span class="badge bg-dark">
                                            {{ $worker->name }}
                                        </span>
                                    @empty
                                        <span class="text-muted">Sin asignar</span>
                                    @endforelse

                                    @if($remainingWorkers > 0)
                                        <span class="badge bg-light text-dark border">
                                            +{{ $remainingWorkers }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-end text-nowrap">
                                <div class="d-inline-flex flex-wrap gap-2 justify-content-end">
                                    <a href="{{ route('jobs.show', $job) }}" class="btn btn-sm btn-info px-2 py-1">Ver</a>

                                    @if(auth()->user()->role === 'administrador')
                                        <a href="{{ route('jobs.edit', $job) }}" class="btn btn-sm btn-warning px-2 py-1">Editar</a>

                                        <form action="{{ route('jobs.destroy', $job) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Eliminar este encargo?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger px-2 py-1">Borrar</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                No hay encargos todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $jobs->links() }}
        </div>
    </div>
</div>
@endsection