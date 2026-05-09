@extends('layouts.app')

@section('title', 'Ficha del cliente')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h1 class="h4">{{ $client->name }} {{ $client->surname }}</h1>
        <p><strong>DNI/NIF:</strong> {{ $client->dni_nif }}</p>
        <p><strong>Teléfono:</strong> {{ $client->phone }}</p>
        <p><strong>Email:</strong> {{ $client->email }}</p>
        <p><strong>Dirección:</strong> {{ $client->full_address }}</p>
        <p><strong>Tipo:</strong> {{ $client->client_type }}</p>
        <p><strong>Notas:</strong> {{ $client->internal_notes }}</p>

        <hr>

        <h2 class="h5">Encargos</h2>
        @forelse($client->jobs as $job)
            <div class="border rounded p-2 mb-2">
                <strong>{{ $job->name }}</strong> — {{ $job->status }}
            </div>
        @empty
            <p>No tiene encargos todavía.</p>
        @endforelse

        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection