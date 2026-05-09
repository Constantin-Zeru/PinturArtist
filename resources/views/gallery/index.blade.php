@extends('layouts.app')

@section('title', 'Galería')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="h3 mb-1">Galería</h1>
        <p class="text-muted mb-0">Imágenes y vídeos de los encargos y sus fases</p>
    </div>

    @if(auth()->user()->role === 'administrador')
        <a href="{{ route('gallery.create') }}" class="btn btn-primary">Nuevo archivo</a>
    @endif
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" id="gallerySearch" class="form-control" placeholder="Buscar por comentario, encargo o fase...">
            </div>

            <div class="col-md-3">
                <select id="galleryJobFilter" class="form-select">
                    <option value="">Todos los encargos</option>
                    @foreach($jobs as $job)
                        <option value="{{ $job->id }}">{{ $job->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select id="galleryPhaseFilter" class="form-select">
                    <option value="">Todas las fases</option>
                    @foreach($phases as $phase)
                        <option value="{{ $phase->id }}">{{ $phase->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <select id="galleryTypeFilter" class="form-select">
                    <option value="">Todo</option>
                    <option value="before">Antes</option>
                    <option value="during">Durante</option>
                    <option value="after">Después</option>
                    <option value="video">Vídeos</option>
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <small class="text-muted" id="galleryCounter">
                Mostrando {{ $items->count() }} elementos
            </small>

            <button type="button" class="btn btn-outline-secondary btn-sm" id="galleryReset">
                Limpiar filtros
            </button>
        </div>
    </div>
</div>

<div class="row g-3" id="galleryGrid">
    @forelse($items as $item)
        @php
            $isVideo = $item->media_kind === 'video';
            $fileUrl = asset('storage/' . $item->file_path);
            $jobName = $item->job?->name ?? '-';
            $phaseName = $item->phase?->name ?? '-';
            $comment = $item->comment ?? '';
            $kindLabel = match($item->media_kind) {
                'before' => 'Antes',
                'during' => 'Durante',
                'after' => 'Después',
                'video' => 'Vídeo',
                default => 'Archivo',
            };
        @endphp

        <div class="col-md-6 col-lg-4 gallery-item"
             data-job="{{ $item->job_id ?? '' }}"
             data-phase="{{ $item->phase_id ?? '' }}"
             data-type="{{ $item->media_kind }}"
             data-search="{{ strtolower(trim($jobName . ' ' . $phaseName . ' ' . $comment . ' ' . $kindLabel)) }}">
            <div class="card shadow-sm h-100 gallery-card">
                <div class="gallery-thumb-wrap">
                    @if($isVideo)
                        <video class="gallery-thumb" muted preload="metadata">
                            <source src="{{ $fileUrl }}">
                        </video>
                    @else
                        <img src="{{ $fileUrl }}" alt="Archivo de galería" class="gallery-thumb">
                    @endif

                    <div class="gallery-badge">{{ $kindLabel }}</div>
                </div>

                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                        <div>
                            <h5 class="card-title mb-1">{{ $jobName }}</h5>
                            <div class="text-muted small">{{ $phaseName }}</div>
                        </div>
                    </div>

                    <p class="card-text small mb-3">
                        {{ $comment ?: 'Sin comentario.' }}
                    </p>

                    <div class="mt-auto">
                        <div class="d-flex flex-wrap gap-1 mb-3">
                            <span class="badge bg-dark">Subido: {{ optional($item->created_at)->format('d/m/Y') }}</span>
                            <span class="badge bg-info text-dark">{{ $item->uploadedBy?->name ?? 'Sistema' }}</span>
                        </div>

                        <div class="d-flex gap-2 flex-wrap">
                            <button
                                type="button"
                                class="btn btn-sm btn-primary gallery-open"
                                data-bs-toggle="modal"
                                data-bs-target="#galleryModal"
                                data-url="{{ $fileUrl }}"
                                data-type="{{ $item->media_kind }}"
                                data-title="{{ $jobName }} · {{ $phaseName }}"
                                data-comment="{{ $comment ?: 'Sin comentario.' }}"
                            >
                                Ver
                            </button>

                            @if(auth()->user()->role === 'administrador')
                                <form action="{{ route('gallery.destroy', $item) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar este archivo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Borrar</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info mb-0">
                No hay archivos todavía.
            </div>
        </div>
    @endforelse
</div>

<div class="mt-3">
    {{ $items->links() }}
</div>

<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-1" id="galleryModalTitle">Vista previa</h5>
                    <small class="text-muted" id="galleryModalComment"></small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center" id="galleryModalBody"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/gallery.js') }}"></script>
@endpush