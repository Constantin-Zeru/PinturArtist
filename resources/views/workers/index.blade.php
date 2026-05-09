@extends('layouts.app')

@section('title', 'Trabajadores')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Trabajadores</h1>
        <p class="text-muted mb-0">Alta y gestión de usuarios con rol trabajador</p>
    </div>

    <a href="{{ route('workers.create') }}" class="btn btn-primary">Nuevo trabajador</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th class="text-end text-nowrap">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($workers as $worker)
                        <tr>
                            <td class="fw-semibold">{{ $worker->name }} {{ $worker->surname }}</td>
                            <td>{{ $worker->email }}</td>
                            <td>{{ $worker->phone ?? '-' }}</td>
                            <td><span class="badge bg-info text-dark">Trabajador</span></td>
                            <td class="text-end text-nowrap">
                                <div class="d-inline-flex flex-wrap gap-2 justify-content-end">
                                    <a href="{{ route('workers.edit', $worker) }}" class="btn btn-sm btn-warning">Editar</a>

                                    <form action="{{ route('workers.destroy', $worker) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Eliminar este trabajador?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Borrar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">No hay trabajadores todavía.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $workers->links() }}
        </div>
    </div>
</div>
@endsection