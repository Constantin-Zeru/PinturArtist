@csrf

@php
    $mediaKind = old('media_kind', $gallery->media_kind ?? 'before');
    $selectedJobId = old('job_id', $gallery->job_id ?? '');
    $selectedPhaseId = old('phase_id', $gallery->phase_id ?? '');
@endphp

<div class="mb-3">
    <label class="form-label">Encargo</label>
    <select name="job_id" class="form-select" id="job_id">
        <option value="">-- Selecciona --</option>
        @foreach($jobs as $job)
            <option value="{{ $job->id }}" {{ (string) $selectedJobId === (string) $job->id ? 'selected' : '' }}>
                {{ $job->name }} - {{ $job->client?->name }} {{ $job->client?->surname }}
            </option>
        @endforeach
    </select>
    @error('job_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Fase relacionada</label>
    <select
        name="phase_id"
        class="form-select"
        id="phase_id"
        data-selected-phase="{{ $selectedPhaseId }}"
    >
        <option value="">-- Ninguna --</option>
    </select>
    <div class="form-text">Se cargan solo las fases del encargo seleccionado.</div>
    @error('phase_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Tipo de archivo</label>
    <select name="media_kind" class="form-select" id="media_kind">
        <option value="before" {{ $mediaKind === 'before' ? 'selected' : '' }}>Fotos antes</option>
        <option value="during" {{ $mediaKind === 'during' ? 'selected' : '' }}>Fotos durante</option>
        <option value="after" {{ $mediaKind === 'after' ? 'selected' : '' }}>Fotos después</option>
        <option value="video" {{ $mediaKind === 'video' ? 'selected' : '' }}>Vídeo</option>
    </select>
    @error('media_kind') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Archivo</label>
    <input type="file" name="file" class="form-control" id="file_input" accept="image/*,video/*">
    <div class="form-text">Imagen o vídeo. Se mostrará una vista previa antes de guardar.</div>
    @error('file') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

@if(!empty($gallery?->file_path))
    <div class="mb-3">
        <label class="form-label">Archivo actual</label>
        <div class="border rounded p-2 bg-light">
            @if(str_starts_with($gallery->media_kind, 'video'))
                <video controls class="w-100" style="max-height: 300px;">
                    <source src="{{ asset('storage/' . $gallery->file_path) }}">
                </video>
            @else
                <img src="{{ asset('storage/' . $gallery->file_path) }}" class="img-fluid" alt="Archivo actual">
            @endif
        </div>
    </div>
@endif

<div class="mb-3" id="preview_wrap" style="display:none;">
    <label class="form-label">Vista previa nueva</label>
    <div class="border rounded p-2 bg-light">
        <img id="image_preview" class="img-fluid d-none" alt="Vista previa de imagen">
        <video id="video_preview" class="w-100 d-none" controls></video>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Comentario</label>
    <textarea name="comment" class="form-control" rows="4">{{ old('comment', $gallery->comment ?? '') }}</textarea>
    @error('comment') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<button type="submit" class="btn btn-success">Guardar</button>
<a href="{{ route('gallery.index') }}" class="btn btn-secondary">Volver</a>

@push('scripts')
<script src="{{ asset('assets/js/gallery.js') }}"></script>
@endpush