@extends('layouts.app')

@section('title', 'Archivo de galería')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h1 class="h4">Archivo</h1>
        <p><strong>Encargo:</strong> {{ $gallery->job?->name }}</p>
        <p><strong>Fase:</strong> {{ $gallery->phase?->name ?? '-' }}</p>
        <p><strong>Subido por:</strong> {{ $gallery->uploadedBy?->name }} {{ $gallery->uploadedBy?->surname }}</p>
        <p><strong>Comentario:</strong> {{ $gallery->comment ?? '-' }}</p>

        @if(str_starts_with($gallery->media_kind, 'video'))
            <video controls class="w-100" style="max-height:500px;">
                <source src="{{ asset('storage/'.$gallery->file_path) }}">
            </video>
        @else
            <img src="{{ asset('storage/'.$gallery->file_path) }}" class="img-fluid">
        @endif
    </div>
</div>
@endsection