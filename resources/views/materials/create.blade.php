@extends('layouts.app')

@section('title', 'Nuevo material')

@section('content')
<h1 class="h3 mb-3">Nuevo material</h1>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('materials.store') }}" method="POST">
            @include('materials._form')
        </form>
    </div>
</div>
@endsection