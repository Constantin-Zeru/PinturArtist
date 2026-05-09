@extends('layouts.app')

@section('title', 'Editar archivo')

@section('content')
<h1 class="h3 mb-3">Editar archivo</h1>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('gallery._form', ['gallery' => $gallery, 'jobs' => $jobs, 'phases' => $phases])
        </form>
    </div>
</div>
@endsection