@extends('layouts.app')

@section('title', 'Nueva fase')

@section('content')
<h1 class="h3 mb-3">Nueva fase</h1>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('phases.store') }}" method="POST">
            @include('phases._form', ['jobs' => $jobs, 'users' => $users, 'materials' => $materials])
        </form>
    </div>
</div>
@endsection