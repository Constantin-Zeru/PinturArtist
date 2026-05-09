@extends('layouts.app')

@section('title', 'Editar material')

@section('content')
<h1 class="h3 mb-3">Editar material</h1>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('materials.update', $material) }}" method="POST">
            @method('PUT')
            @include('materials._form', ['material' => $material])
        </form>
    </div>
</div>
@endsection