@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Clientes</h1>

    @if(in_array(auth()->user()->role, ['administrador', 'encargado']))
        <a href="{{ route('clients.create') }}" class="btn btn-primary">Nuevo cliente</a>
    @endif
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>DNI/NIF</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                    <tr>
                        <td>{{ $client->name }} {{ $client->surname }}</td>
                        <td>{{ $client->dni_nif }}</td>
                        <td>{{ $client->phone }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->client_type }}</td>
                        <td class="text-end">
                            <a href="{{ route('clients.show', $client) }}" class="btn btn-sm btn-info">Ver</a>

                            @if(in_array(auth()->user()->role, ['administrador', 'encargado']))
                                <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-warning">Editar</a>

                                <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar este cliente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Borrar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay clientes todavía.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $clients->links() }}
    </div>
</div>
@endsection