@extends('layouts.app')

@section('title', 'Materiales')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Materiales</h1>

    @if(in_array(auth()->user()->role, ['administrador', 'encargado']))
        <a href="{{ route('materials.create') }}" class="btn btn-primary">Nuevo material</a>
    @endif
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Unidad</th>
                    <th>Coste</th>
                    <th>Proveedor</th>
                    <th>Activo</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materials as $material)
                    <tr>
                        <td>{{ $material->name }}</td>
                        <td>{{ $material->unit_measurement }}</td>
                        <td>{{ $material->cost }}</td>
                        <td>{{ $material->provider }}</td>
                        <td>{{ $material->active ? 'Sí' : 'No' }}</td>
                        <td class="text-end">
                            <a href="{{ route('materials.show', $material) }}" class="btn btn-sm btn-info">Ver</a>

                            @if(in_array(auth()->user()->role, ['administrador', 'encargado']))
                                <a href="{{ route('materials.edit', $material) }}" class="btn btn-sm btn-warning">Editar</a>

                                <form action="{{ route('materials.destroy', $material) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar este material?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Borrar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay materiales todavía.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $materials->links() }}
    </div>
</div>
@endsection