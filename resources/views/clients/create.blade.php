@extends('layouts.app')

@section('title', 'Nuevo cliente')

@section('content')
<h1 class="h3 mb-3">Nuevo cliente</h1>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('clients.store') }}" method="POST">
            @include('clients._form')
        </form>
    </div>
</div>
@endsection