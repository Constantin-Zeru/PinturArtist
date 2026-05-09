@extends('layouts.app')

@section('title', 'Editar cliente')

@section('content')
<h1 class="h3 mb-3">Editar cliente</h1>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('clients.update', $client) }}" method="POST">
            @method('PUT')
            @include('clients._form', ['client' => $client])
        </form>
    </div>
</div>
@endsection