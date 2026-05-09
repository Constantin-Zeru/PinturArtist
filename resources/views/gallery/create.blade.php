@extends('layouts.app')

@section('title', 'Subir archivo')

@section('content')
<h1 class="h3 mb-3">Subir archivo</h1>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
            @include('gallery._form', ['jobs' => $jobs, 'phases' => $phases])
        </form>
    </div>
</div>
@endsection