@extends('layouts.app')

@section('title', 'Editar fase')

@section('content')
<h1 class="h3 mb-3">Editar fase</h1>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('phases.update', $phase) }}" method="POST">
            @method('PUT')
            @include('phases._form', ['phase' => $phase, 'jobs' => $jobs, 'users' => $users, 'materials' => $materials])
        </form>
    </div>
</div>
@endsection