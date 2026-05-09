@extends('layouts.app')

@section('title', 'Editar encargo')

@section('content')
<h1 class="h3 mb-3">Editar encargo</h1>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('jobs.update', $job) }}" method="POST">
            @method('PUT')
            @include('jobs._form', ['job' => $job, 'clients' => $clients, 'workers' => $workers])
        </form>
    </div>
</div>
@endsection