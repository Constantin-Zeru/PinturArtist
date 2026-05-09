@extends('layouts.app')

@section('title', 'Nuevo encargo')

@section('content')
<h1 class="h3 mb-3">Nuevo encargo</h1>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('jobs.store') }}" method="POST">
            @include('jobs._form', ['clients' => $clients, 'workers' => $workers])
        </form>
    </div>
</div>
@endsection