@extends('layouts.app')

@section('title', 'Editar presupuesto')

@section('content')
<h1 class="h3 mb-3">Editar presupuesto base</h1>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('budgets.update', $budget) }}" method="POST">
            @method('PUT')
            @include('budgets._form', ['budget' => $budget, 'jobs' => $jobs])
        </form>
    </div>
</div>
@endsection