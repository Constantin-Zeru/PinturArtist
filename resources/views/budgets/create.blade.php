@extends('layouts.app')

@section('title', 'Nuevo presupuesto')

@section('content')
<h1 class="h3 mb-3">Nuevo presupuesto base</h1>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('budgets.store') }}" method="POST">
            @include('budgets._form', ['jobs' => $jobs])
        </form>
    </div>
</div>
@endsection