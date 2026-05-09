@extends('layouts.app')

@section('title', 'Editar incidencia')

@section('content')
<h1 class="h3 mb-3">Editar incidencia</h1>
<div class="card shadow-sm"><div class="card-body">
    <form action="{{ route('incidents.update', $incident) }}" method="POST">
        @method('PUT')
        @include('incidents._form', ['incident' => $incident, 'jobs' => $jobs, 'phases' => $phases])
    </form>
</div></div>
@endsection