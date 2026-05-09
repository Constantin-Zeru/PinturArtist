@extends('layouts.app')

@section('title', 'Nueva incidencia')

@section('content')
<h1 class="h3 mb-3">Nueva incidencia</h1>
<div class="card shadow-sm"><div class="card-body">
    <form action="{{ route('incidents.store') }}" method="POST">
        @include('incidents._form')
    </form>
</div></div>
@endsection